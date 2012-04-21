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
			
			$bigFile		= PROJECTS_URL . $project['slug'] . '/' . $data['file'];				
			$thumbFile		= $data['file'];
			$thumbWidth		= $clerk->getSetting( "projects_filethumbnail", 1 );
			$thumbHeight	= $clerk->getSetting( "projects_filethumbnail", 2 );
			$intelliScaling	= $clerk->getSetting( "projects_thumbnailIntelliScaling", 1 );
			$location		= PROJECTS_URL . $project['slug'] . "/";
			
			$thumbnail		= dynamicThumbnail( $thumbFile, $location, $thumbWidth, $thumbHeight, $intelliScaling, "short" );
			
			$title = '" alt="'. $data['title'] .'" title="'. $data['title'] .' - '. html_entity_decode( $data['caption'] ) .'"';
			
			//check if Hide File Info is set
			if(!$clerk->getSetting('projects_hideFileInfo',1)){
				$imgTitle = '<span class="title">'. $data['title'] .'</span>';
				$imgCaption = '<span class="caption">'. $data['caption'] .'</span>';
			}else{
				$imgTitle = '';
				$imgCaption = '';
			}
			
			if ( $thumbWidth == 0 ) $thumbWidth= "auto";
			if ( $thumbHeight == 0 ) $thumbHeight= "auto";
			
			$sources.= '<a href="'. $bigFile .'" rel="lightbox-'. $data['filegroup'].'" ' .$title.'><img src="' . $thumbnail . '" width="' . $thumbWidth . '" height="' . $thumbHeight . '" alt="' . $bigFile . '" alt="" /></a><div class="imgInfo">'.$imgTitle.' '.$imgCaption.'</div>';
		}
	}
	
	return $sources; 
}

?>