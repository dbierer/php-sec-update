<?php
/**
 * ViewFactory.php
 */
namespace src\controller\factory;
use PDO;
use src\controller\FrontController;
use src\view\View;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
class FrontControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $db = $container->get('db');
        try{
            $pdo = new PDO($db['dsn'], $db['user'], $db['pass'], [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            $view = $container->get(View::class);
            $url = $this->buildVulnerabilityDirectUrl();
            $view->setVariable('url', $url);
            $controller = new FrontController($container, $pdo, $view , $url);
            $controller->setSession();
            $session = $controller->getSession();
            if(isset($session['security']) && $session['security'] === 'zf'){
                $controller->setAdapter(new Adapter($db));
            }
            return $controller;
        } catch (\Throwable $e){
            FrontController::logError($e->getMessage(), __LINE__, __FILE__);
        }
        return false;
    }

    /**
     * This builds a dynamic URL for use within the individual vulnerability code.
     */
    protected function buildVulnerabilityDirectUrl(){
        $segments = explode('/', $_SERVER['PHP_SELF']);
        $path = array_slice($segments, 0, count($segments) - 2);
        array_shift($path);
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . implode('/', $path);
    }
}
