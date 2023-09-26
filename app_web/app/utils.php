<?php

// Routeur
function router(string $controller, string $action, $param, $param2): void 
{
    try {
        $file_path = '../app/controllers/' . $controller . 'Controller.php';
        // On vérifie que le contrôleur existe
        if (file_exists($file_path)) {
            $controllerName = ucfirst($controller) . 'Controller';
            $controller = new $controllerName();
            // On vérifie que la méthode du contrôleur existe 
            if (method_exists($controller, $action)) {
                if (!empty($param2)) {
                    $controller->$action($param, $param2);
                } elseif (!empty($param)) {
                    $controller->$action($param);
                } else {
                    $controller->$action();
                }
            } else {
                throw new Exception("Action inexitante.");
            }
        } else {
            throw new Exception("Contrôleur inexitant.");
        }    
    } catch (Exception $e) {
        render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
    }
}

// Affiche une vue
function render(string $path, array $params = []): void 
{
    try {
        $file_path = '../app/views/' . $path . '.views.php';
        // On vérifie que la vue existe
        if (file_exists($file_path)) {
            ob_start();
            extract($params);
            require_once $file_path;
            $pageContent = ob_get_clean();
            require_once  '../app/views/default.views.php';
        } else {
            throw new Exception("Page inexistante.");
        }
    } catch (Exception $e) {
        render('alert', ['pageTitle' => 'Erreur', 'errorMessage' => $e->getMessage()]);
    }
}
