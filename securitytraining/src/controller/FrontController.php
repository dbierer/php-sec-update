<?php
/**
 * Front controller Class
 */
namespace src\controller;
class FrontController {
    public const LOG = __DIR__ . '/../../data/log/error.log';
	protected $user, $action, $url, $session, $container, $view, $pdo, $adapter = null;

    /**
     * FrontController constructor.
     * @param $container
     * @param $pdo
     * @param $view
     * @param $url
     */
    public function __construct($container, $pdo, $view, $url) {
	    $this->container = $container;
	    $this->pdo = $pdo;
	    $this->view = $view;
        $this->url = $url;
	}

    /**
     * Returns filename of error log
     * @return string self::LOG
     */
    public static function getErrorLog() {
        return self::LOG;
    }

    /**
     *
     */
    public function indexAction(){
        $menuActions = $this->container->get('menu');
        if ($_POST) {
            $referer = $_SERVER['HTTP_REFERER'];
            preg_match('/action=(\w+?)$/', $referer, $matches);
            if (!empty($matches[1])) {
                $this->action = $matches[1];
                if (isset($this->session['username'])) {
                     if (array_key_exists($this->action, $menuActions['vulnerabilities'])) {
                        $this->vulnerabilityAction();
                    }
                }
            }
        }
        if (isset($_POST['username'])
            && isset($_POST['password'])
            && isset($_POST['action'])
            && ctype_alnum($_POST['username'])
            && ctype_alpha($_POST['action'])){
            $this->user['username'] = $_POST['username'];
            $this->user['password'] = $_POST['password'];
            if(!isset($this->session['username'])){
                $this->loginAction();
            } else {
                $this->setViewAndRender(null, ['page_id' => 'home', 'name' => 'home', 'body' => 'main_body']);
            }
        } elseif ($_GET && isset($_GET['action'])
                 && preg_match('/[a-z ]+/', strtolower($_GET['action'])))
        {
            $this->action = strtolower($_GET['action']);
            if(!isset($this->session['username']) && !$this->authenticate()){
                $this->pushMessage("Please login");
                $this->logoutAction();
            } elseif(isset($this->session['username']) && in_array($this->action, $menuActions['main'])){
                $action = explode(' ', $this->action);
                $this->action = current($action);
                $call = $this->action . 'Action';
                $this->$call();
            }elseif(isset($this->session['username']) && array_key_exists($this->action, $menuActions['vulnerabilities'])){
                $this->vulnerabilityAction();
            }
        } else {
            $this->pushMessage("Please login");
            $this->logoutAction();
        }
	}

    /**
     *
     */
    public function homeAction() {
		$page            = $this->container->get('page');
		$page['title']   .= $page['title_separator'] . 'Welcome';
		$page['page_id'] = 'home';
		$page['body']    = 'main_body';
		$this->view->setVariable('page', $page);
		$items = $this->getLeftBlock($page);
		foreach($items as $key => $value) {
			$this->view->setVariable($key, $value);
		}
		$messagesHtml = $this->popMessagesToHtml();
		$this->view->setVariables(['messagesHtml' => $messagesHtml]);
		$this->view->render();
	}

    /**
     * This is also authenticating user
     */
    public function loginAction() {
        $data = null;
        if($this->authenticate()){
			$user = $data['username'] ?? 'Guest';
            $this->pushMessage("You are logged in as '" . $user . "'");
            $page          = $this->container->get('page');
            $page['title'] .= $page['title_separator'] . 'Welcome';
            $this->view->setTemplate('main');
        }else {
            // Login failed
            $this->view->setTemplate('login');
            $this->pushMessage("Login failed");
        }
        $this->setViewAndRender(null, ['page_id' => 'home', 'name' => 'home', 'body' => 'main_body']);
	}

	protected function authenticate(){
        $data = NULL;
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user = ?');
            $stmt->execute([$this->user['username']]);
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            // Check if we have login
            if($data) {
                $valid = FALSE;
                // check against old MD5 password
                 if (md5($this->user['password']) == $data['password']) {
                     $valid = TRUE;
                // check against BCRYPT password
                } elseif (password_verify($this->user['password'], $data['password_zf'])) {
                     $valid = TRUE;
                }
                if (!$valid) {
                    $message = sprintf('Failed login attempt as user "%s" using password "%s"', $this->user['username'], $this->user['password']);
                    self::logError($message, __LINE__, __FILE__);
                    return FALSE;
                }
                if(!isset($this->session['username']) && !isset($this->session['role'])){
                    $this->session['username'] = $data['user'];
                    $this->session['role'] = $data['role'];
                }
                return TRUE;
            }
        } catch (\Throwable $e){
            self::logError($e->getMessage(), __LINE__, __FILE__);
        }

        return FALSE;
    }

    /**
     *
     */
    public function logoutAction() {
        session_destroy();
		$this->view->setTemplate('login');
		if(!in_array('Please login', $this->session['messages']))$this->pushMessage("You have logged out");
        $this->setViewAndRender(null, ['page_id' => 'home', 'name' => 'home', 'body' => 'main_body']);
	}

    /**
     *
     */
    public function setSession() {
		if( ! isset($_SESSION)) {
		    session_start();
		}
		$this->session =& $_SESSION ?? [];
	}

    /**
     *
     */
    public function securityAction() {
		$page = $this->container->get('page');
		$page['title'] .= $page['title_separator'] . $page['title'];
		$html = '';

		if(isset($_GET['seclev_submit'])) {
			$securityLevel = 'with';

			switch($_GET['security']) {
				case 'without':
					$securityLevel = 'without';
					break;
				case 'zf':
					$securityLevel = 'zf';
					break;
			}
			$this->session['security'] = $securityLevel;
			$this->pushMessage("Security level set to $securityLevel");
		}

		// Set the security level
		$securityOptionsHtml = $securityLevelHtml = '';
		foreach($this->container->get('security_levels') as $level) {
			$selected = '';
			if(isset($this->session['security']) && $level === $this->session['security']) {
				$selected          = ' selected="selected"';
				$securityLevelHtml = "<p>Security Level is currently \"<em>$level</em>\"<p>";
			}
			if($level === 'with' && $securityLevelHtml === ''){
				$selected          = ' selected="selected"';
				$securityLevelHtml = "<p>Security Level is currently \"<em>$level</em>\"<p>";
			}
			$securityOptionsHtml .= "<option value=\"{$level}\"{$selected}>{$level}</option>";
		}

		$this->view->setVariables([
			'securityLevelHtml'   => $securityLevelHtml,
			'securityOptionsHtml' => $securityOptionsHtml
		]);
		$this->setViewAndRender($html, ['page_id' => 'security options', 'name' => 'security', 'body' => 'security']);
	}

    /**
     * @param string|null $name
     */
    public function vulnerabilityAction() {
		$page = $this->container->get('page');
		$page['title'] .= $page['title_separator'] . 'Vulnerability: ';
		$file = isset($this->session['security']) ? $this->session['security'] . '.php' : 'with.php';
		$html = '';
		if(file_exists(__DIR__ . "/../vulnerabilities/{$this->action}/source/$file")){
            require __DIR__ . "/../vulnerabilities/{$this->action}/source/$file";
        }
		$vulnerabilities = $this->container->get('menu')['vulnerabilities'];
		if(array_key_exists($this->action, $vulnerabilities)){
            $page['title'] .= $vulnerabilities[$this->action];
        } else {
            $page['title'] .= 'Unknown';
            $this->action = 'main_body';
        }
		$this->setViewAndRender($html, ['page_id' => $this->action, 'name' => $this->action, 'body' => $this->action]);
	}

    /**
     *
     */
    public function phpInfoAction() {
        $page            = $this->container->get('page');
        $this->view->setVariable('page', $page);
        $this->setViewAndRender(null, ['page_id' => 'phpinfo', 'name' => 'PhpInfo', 'body' => 'phpinfo']);
    }

    /**
     * @param string|null $html
     * @param array $pageData
     */
    protected function setViewAndRender(string $html = null, array $pageData) {
		$page                  = $this->container->get('page');
		$page['page_id']       = $pageData['page_id'];
		$page['help_button'] = $page['source_button'] = $pageData['name'];
		$page['body']          = $pageData['body'];
		$this->view->setVariable('page', $page);
		$items = $this->getLeftBlock($page);
		foreach($items as $key => $value) {
			$this->view->setVariable($key, $value);
		}
		$this->view->setVariable('html', $html);
        $this->view->setVariable('company', $this->container->get('company')['name']);
		$this->view->render();
	}

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param null $adapter
     */
    public function setAdapter($adapter): void
    {
        $this->adapter = $adapter;
    }

    /**
     * @return string
     */
    protected function getCurrentUser() {
		return (isset($this->session['username']) ? $this->session['username'] : '');
	}

    /**
     * @return string
     */
    protected function getSecurityLevel() {
		return isset($this->session['security']) ? $this->session['security'] : 'with';
	}

    /**
     * @param $message
     */
    public static function logError(string $message, int $line, string $file) {
        $pattern = '%19s : %04d : %20s : %s' . PHP_EOL;
        error_log(sprintf($pattern, date('Y-m-d H:i:s'), $line, $file, $message), 3, self::LOG);
	}

    /**
     * @param $message
     */
    protected function pushMessage(string $message) {
		if( ! isset($this->session['messages'])) {
			$this->session['messages'] = array();
		}
		$this->session['messages'][] = $message;
	}

    /**
     * @return bool|mixed
     */
    protected function popMessage() {
		if( ! isset($this->session['messages']) || count($this->session['messages']) == 0) {
			return false;
		}
		return array_shift($this->session['messages']);
	}

    /**
     * @return string
     */
    private function popMessagesToHtml() {
		$messagesHtml = '';
		while($message = $this->popMessage()) {    // TODO- sharpen!
			$messagesHtml .= "<div class=\"message\">{$message}</div>";
		}

		return $messagesHtml;
	}

    /**
     * @param array $page
     * @return array
     */
    protected function getLeftBlock(array $page) {
        $menuBlockHtml = null;
        foreach($this->container->get('menu') as $mkey => $menus) {
            if($mkey === 'vulnerabilities') $menuBlockHtml .= '<h4 style="margin: 10px 0 0 0">Vulnerabilities</h4>';
            foreach($menus as $ikey => $item) {
                $img = $itemImage = $keyImage = null;
                $selectedClass = ($ikey === $page['page_id'] || $item === $page['page_id']) ? 'selected' : null;
                if($itemImage = file_exists("images/$item.png") || $keyImage = file_exists("images/$ikey.png")){
                    if($itemImage) $img = "<div><img width=\"15\" height=\"15\" src=\"images/$item.png\"></div>";
                    if($keyImage) $img = "<div><img width=\"15\" height=\"15\" src=\"images/$ikey.png\"></div>";
                }

                $entry = is_array($item)? ucwords($ikey) : ucwords($item);
                $action = is_numeric($ikey) ? $item : $ikey;
                $menuBlockHtml .= "<li onclick=\"window.location='index.php?action=$action'\" class=\"$selectedClass\">$img<a href=\"index.php?action=$action\">$entry</a></li>";
			}
        }
        $menuHtml = "<ul>{$menuBlockHtml}</ul>";

        // Get security cookie --
		$securityLevelHtml = isset($this->session['security']) ? $this->session['security'] : 'with';
		$userInfoHtml = $this->getCurrentUser() ? '<b>Username:</b> ' . $this->getCurrentUser() . '<br>' : '';
		$messagesHtml = $this->popMessagesToHtml();

		if($messagesHtml) {
			$messagesHtml = "<div class=\"body_padded\">{$messagesHtml}</div>";
		}

		$systemInfoHtml = "<div align=\"left\">{$userInfoHtml}<b>Security Level:</b> {$securityLevelHtml}</div>";

		return [
			'menuHtml'       => $menuHtml,
			'userInfoHtml'   => $userInfoHtml,
			'messagesHtml'    => $messagesHtml,
			'systemInfoHtml' => $systemInfoHtml
		];
	}
}

