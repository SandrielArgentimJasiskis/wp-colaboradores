<?php
    
    function require_files_from_directory($directory) {
        $dir_contents = scandir($directory);
        foreach ($dir_contents as $file) {
            if (!in_array($file, ['.', '..'])) {
                require_once($directory . '/' . $file);
            }
        }
    }
    
    // Models
    require_files_from_directory(DIR_COLABORADORES . '/models/system');
    require_files_from_directory(DIR_COLABORADORES . '/models/admin');
    require_files_from_directory(DIR_COLABORADORES . '/models/website');
    
    // Views
    require_files_from_directory(DIR_COLABORADORES . '/views/admin');
    require_files_from_directory(DIR_COLABORADORES . '/views/website');