<?php
require "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
   $path = (isset($_GET['f']))?base64url_decode($_GET['f']): ROOT;
   $breadcrumbN = count(explode('/', ROOT)) - 1;

   $breadcrumbs = array();
   $pathA = explode('/',$path);
   $urlP = '';
   $bar = '';
   foreach ($pathA as $key=>$tpath) {
       $urlP .= $bar.$tpath;
       $url = ($key === 0)? '/' :'?f='.base64url_encode($urlP);
       if($key >= $breadcrumbN){
         $breadcrumbs[] = array('url'=>$url, 'name'=>$tpath);
       }
       $bar = '/';
   }
   $nBreadcrumb = count($breadcrumbs);
   $title = $breadcrumbs[$nBreadcrumb -1]['name'];
   $diretorio = dir($path);
    	$arquivos = array();
	$folders = array();
	$i = 0;
	$vidExtensions = array('mp4');
	$imageExtensions = array('jpg', 'jpeg', 'png', 'gif', 'svg', 'tif', 'bmp');
	while($arquivo = $diretorio -> read()):
		if($arquivo !== '.' && $arquivo !== '..'):
			$fullpath = $path.'/'.$arquivo;
			if(is_dir($fullpath)){
				$folders[$i]['url'] = base64url_encode($fullpath);;
				$folders[$i]['path'] = $fullpath;
				$folders[$i]['name'] = $arquivo;
			}else{
				$parts = explode('.',$arquivo);
				$ext = strtolower($parts[count($parts) - 1]);
				$tipo = 'file';
				$tipo = (in_array($ext, $vidExtensions))? 'video' : $tipo;
				$tipo = (in_array($ext, $imageExtensions))? 'image' : $tipo;
				$arquivos[$i]['path'] = $fullpath;
				$arquivos[$i]['name'] = $arquivo;
				$arquivos[$i]['tipo'] = $tipo;
				$arquivos[$i]['ext'] = $ext;
			}
			$i++;
		endif;
	endwhile;
	$diretorio -> close();?><html lang="pt-BR">
	<head>
		<title>Navigator</title>
		<meta charset="UTF-8">
		<script src="/js/jquery-3.1.0.min.js"></script>
		<script src="/js/navigator.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/navigator.css">
	</head>
	<body>
		<h1><?=$title?></h1>
    <div id="breadcrumbs">
      <?php foreach($breadcrumbs as $key=>$crumb): if(($nBreadcrumb -1 > $key) ):?>
        <a href="<?=$crumb['url']?>"><?=$crumb['name']?></a>
      <?php else:?>
        <span><?=$crumb['name']?></span>
      <?php endif;?>
      <?php endforeach;?>
    </div>
		<div class="list">
			<?php foreach($folders as $folder):?>
			<a class="folder" href="?f=<?=$folder['url']?>" data-path="<?=$folder['path']?>"><?=$folder['name']?></a>
			<?php endforeach;?>
			<?php foreach($arquivos as $arquivo):?>
			<div class="<?=$arquivo['tipo']?>" data-path="<?=$arquivo['path']?>">
        <div><?=$arquivo['name']?></div>
        <div>
          <a class="ico download" href="./download.php?d=<?=$arquivo['path']?>" target="download"></a>
        </div>
      </div>
			<?php endforeach;?>
		</div>

		<div id="popShow">
		    <div><span id="fecharPopShow">x</span></div>
		    <div id="popContent"></div>
		</div>
    <iframe name="download" id="download"></iframe>
	</body>
</html>
