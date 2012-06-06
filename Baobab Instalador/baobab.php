<?php

/*
Plugin Name: Baobab Framework
Plugin URI: http://proyectos.ead.pucv.cl/baobab/version-2/
Description: Baobab es un Framework de Wordpress. En él podrás generar Proyectos, Debates, invitar gente a Eventos, publicar Noticias o alguna Idea y hasta ofrecer o comprar productos.Version: 0.1
Author: Joaquin Martel y Jaime Perez
Author URI: 
 */


/**
 * Plugin activation.
 */
 
 
register_activation_hook(__FILE__, 'baobabActivate');

function baobabActivate()
{
	// creacion de la base de datos necesaria.
	$sql_t_participantes = "CREATE TABLE IF NOT EXISTS wp_participantes (
		  id bigint(20) NOT NULL auto_increment,
		  post_id int(11) NOT NULL,
		  user_id int(11) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";


	$sql_t_votes ="CREATE TABLE IF NOT EXISTS wp_votes (
		  id bigint(20) NOT NULL auto_increment,
		  post_id int(11) NOT NULL,
		  vote_text varchar(255) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";

	$sql_t_votes_user = " CREATE TABLE IF NOT EXISTS wp_votes_user (
		  id bigint(20) NOT NULL auto_increment,
		  post_id int(11) NOT NULL,
		  vote_id int(11) NOT NULL,
		  user_id int(11) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
	mysql_query($sql_t_participantes);
	mysql_query($sql_t_votes);
	mysql_query($sql_t_votes_user);


	//Creación de las Páginas de Archivo (Custom Posts)	$pages = array("Proyecto","Idea","Debate","Evento","Mercado");


	foreach ($pages as $value) {
		$post = array(
		  'post_name' => $value,
		  'post_status' => 'publish',
		  'post_title' => $value,
		  'post_type' => 'page',
		);
		$id = wp_insert_post( $post, $wp_error);
		$template = strtolower("archive-".$value.".php");
		$update = update_post_meta($id, '_wp_page_template', $template);
	}	//Creación de los Formularios	$pages = array("enviar-proyecto","enviar-idea","enviar-debate","enviar-evento","enviar-mercado");

	foreach ($pages as $value) {
		$post = array(
		  'post_name' => $value,
		  'post_status' => 'publish',
		  'post_title' => $value,
		  'post_type' => 'page',
		);
		$id = wp_insert_post( $post, $wp_error);
		$template = strtolower("plantilla-".$value.".php");
		$update = update_post_meta($id, '_wp_page_template', $template);
	}
			//Creacion del archivo de Noticias (Posts Nativos de Wordpress)		$pages = array("Noticias");

	foreach ($pages as $value) {
		$post = array(
		  'post_name' => $value,
		  'post_status' => 'publish',
		  'post_title' => $value,
		  'post_type' => 'page',
		);
		$id = wp_insert_post( $post, $wp_error);
		$template = strtolower("archive.php");
		$update = update_post_meta($id, '_wp_page_template', $template);
	}			
	$ch = curl_init("http://proyectos.ead.pucv.cl/baobab/Baobab.zip");
	$fp = fopen("../wp-content/themes/Baobab.zip", "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	
	$zip = new ZipArchive; 
    $zip->open('../wp-content/themes/Baobab.zip'); 
    $zip->extractTo('../wp-content/themes/'); 
    $zip->close(); 

	$sql_theme 	= "UPDATE wp_options SET option_value = 'Baobab' WHERE option_name = 'template'";
 	$sql_css	= "UPDATE wp_options SET option_value = 'Baobab' WHERE option_name = 'stylesheet'";
 	$sql_current_theme = "UPDATE wp_options SET option_value = 'Baobab' WHERE option_name = 'current_theme'";

	mysql_query($sql_theme);
	mysql_query($sql_css);
	mysql_query($sql_current_theme);
}	
?>