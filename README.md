# wp-colaboradores
Sistema de Pontos de colaboradores para WordPress

Instalação:
1ª Etapa: 
Baixe os arquivos da pasta "upload" deste respositório.

2ª Etapa:
Vá para a raiz do seu WordPress e faça upload da pasta Upload deste repositório e a descompate-a.

2ª Etapa:
Navegue até o arquivo functions.php e adicione o seguinte trecho de código: uma linha abaixo da tag de abertura do PHP "<?php":
if (!defined('DIR_COLABORADORES')) {
	define('DIR_COLABORADORES', __DIR__  . '/../../wp-colaboradores/');
}
require_once(DIR_COLABORADORES . 'wp-colaboradores.php');
