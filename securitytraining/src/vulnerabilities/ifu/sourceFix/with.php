<?php
/**
 * Fix vulnerabilities found in this file
 */
function createRandomFilename($dir, $ext)
{
	static $count = 10;
	$fn = $dir . date('Y-m-d-') . bin2hex(random_bytes(8)) . $ext;
	if (file_exists($fn)) {
		if ($count--) {
			$fn = createRandomFilename($dir, $ext);
		} else {
			throw new Exception('Error creating unique filename');
		}
	}
	return $fn;
}

$allowedExts = ['jpg','gif','png'];
$html .= '<pre>';
if (isset($_POST['Upload'])) {
	
    if (!is_uploaded_file($_FILES['uploaded']['tmp_name']) ||
        !$_FILES['upload']['error'] == UPLOAD_ERR_OK) {
        $html .= 'Problem with uploaded file ... please try again';
    } else {
        $target_path = __DIR__ . "/safe/uploads/";
        // validate ext
        $ext = pathinfo($_FILES['uploaded']['name'])['extension'] ?? '';
        if (!$ext) {
            $html .= 'No extension';
        } else {
            if (!in_array(strtolower($ext), $allowedExts)) {
                $html .= 'Only image files can be uploaded!';
            } else {
                // create a new random filename
                $fn = createRandomFilename($target_path, $ext);
                // log the original name + random name
                $info = date('Y-m-d H:i:s') . ':' . $fn . ':' . $_FILES['uploaded']['name'] . PHP_EOL;
                file_put_contents(__DIR__ . '/upload.log', $info, FILE_APPEND); 
                if (!move_uploaded_file($_FILES['uploaded']['tmp_name'], $fn)) {
                    $html .= 'Your file was not uploaded.';
                } else {
                    $html .= 'Succesfully uploaded!<br>Click on:<br>';
                    $html .= '<a href="http://securitytraining/vulnerabilities/ifu/source/safe/uploads/' . basename($fn) . '" '
                           . 'target="_blank">' . basename($fn) . '</a>';
                }
            }
        }
    }
}
$html .= '</pre>';
