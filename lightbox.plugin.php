<?php
/**
*	Lightbox Plugin 
*	by Thomas Hurtig
*	version: 1.1
*
*	based on The Secretary Pop Dislpayer Plugin
*	uses Slimbox - (c) Christophe Beyls 2007-2010; http://code.google.com/p/slimbox/
*
*	changelog:
*
*	1.2
*	- resize and intelligent scaling of fullsize image
*	- added "alt" and "title" to <img>
* 	- removed "alt" and "title" from <a> link
*	1.1
*	- added image title and image caption under thumbnail
*
**/

hook('js_frontend', 'addLightboxJs', '', 10);
hook('css_frontend', 'addLightboxCss', '', 10);
hook('displayersList', 'addMyLightbox');

function addMyLightbox( $displayers )
{
	$displayers['Lightbox'] = "lightbox";
	return $displayers;
}

// include slimbox.js
function addLightboxJs(){
	echo requireJs( "jquery.js", true );
	echo requireJs(SYSTEM_URL.'plugins/lightbox/slimbox/js/slimbox2.js');
}

// include slimbox css
function addLightboxCss(){
	echo requireCss(SYSTEM_URL.'plugins/lightbox/slimbox/css/slimbox2.css');
}

function lightbox($project, $files, $group){
	global $clerk;

	$sources = '';

	foreach ( $files as $file => $data ){
		if ( $data['filegroup'] == $group['num'] ){
			
			
			// Handle resizing of large image
			$settings		=	$clerk->getSetting( "projects_fullsizeimg" );
			$do_scale		=	(boolean) $settings['data3'];
			$intelliscale	=	(int) $settings['data2'];
			
			if ( $do_scale )
			{
				list( $width, $height )= explode( "x" , $settings['data1'] );
				$image = dynamicThumbnail( $data['file'], PROJECTS_PATH . $project['slug'] . '/', $width, $height, $intelliscale, "short" );
			}
			else
			{
				list( $width, $height )= getimagesize( PROJECTS_PATH . $project['slug'] . '/' . $data['file'] );
				$image = PROJECTS_URL . $project['slug'] . '/' . $data['file'];
			}

			// create thumbnail
			$thumbWidth		= $clerk->getSetting( "projects_filethumbnail", 1 );
			$thumbHeight	= $clerk->getSetting( "projects_filethumbnail", 2 );
			$intelliScaling	= $clerk->getSetting( "projects_thumbnailIntelliScaling", 1 );
			$location		= PROJECTS_URL . $project['slug'] . "/";
			
			$thumbnail		= dynamicThumbnail( $data['file'], $location, $thumbWidth, $thumbHeight, $intelliScaling, "short" );
			
			$title = '" alt="'. $data['title'] .'" title="'. $data['title'] .' - '. html_entity_decode( $data['caption'] ) .'"';
			
			// check if Hide File Info is set
			if(!$clerk->getSetting('projects_hideFileInfo',1)){
				$imgTitle = '<span class="title">'. $data['title'] .'</span>';
				$imgCaption = '<span class="caption">'. $data['caption'] .'</span>';
			}else{
				$imgTitle = '';
				$imgCaption = '';
			}
			
			if ( $thumbWidth == 0 ) $thumbWidth= "auto";
			if ( $thumbHeight == 0 ) $thumbHeight= "auto";
			
			$sources.= '<div class="file"><a href="'. $image .'" rel="lightbox-'. $data['filegroup'].'"><img src="' . $thumbnail . '" width="' . $thumbWidth . '" height="' . $thumbHeight . $title . ' /></a><div class="imgInfo">'.$imgTitle.' '.$imgCaption.'</div></div>';
		}
	}
	
	return $sources; 
}

?>