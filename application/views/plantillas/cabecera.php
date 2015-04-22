<!DOCTYPE html>
<html lang ="es">
    <head>
        <title>Participacion Ciudadana</title>
	<meta name="description" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--ESTILOS-->
        <!--[if lt IE 9]>
            <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
        <![endif]-->
                
        <script src="//cdn.app-framework-software.intel.com/2.1/appframework.min.js" type="text/javascript"></script>        
        <link rel="stylesheet" type="text/css" href="http://cdn.app-framework-software.intel.com/2.1/af.ui.css" />
        <link rel="stylesheet" type="text/css" href="http://cdn.app-framework-software.intel.com/2.1/icons.css" />
        <script type="text/javascript" charset="utf-8" src="http://cdn.app-framework-software.intel.com/2.1/appframework.ui.min.js"></script>    
        
        
        <!--<script src="<? base_url();?>appframework/appframework.min.js" type="text/javascript"></script>        
        <link rel="stylesheet" type="text/css" href="<? base_url();?>appframework/build/css/af.ui.css" >
        <link rel="stylesheet" type="text/css" href="<? base_url();?>appframework/build/css/icons.css" >
        <script src="<? base_url();?>appframework/ui/appframework.ui.js" type="text/javascript"></script>-->
        
        <script>
            $.ui.useInternalRouting = false;
            $.feat.nativeTouchScroll=true;
        </script>
        
        
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        <script src="<?= base_url();?>js/jquery.js" type="text/javascript"></script>
        <!--<script src="<?= base_url();?>js/incidenciasNueva.js" type="text/javascript"></script>-->
        <?php if(isset($javascript)):?>
            <?php if(!is_array($javascript) && ($javascript != "")):?>
                <?php if($javascript[0] === "/"):?>
                    <script src="<?= $javascript;?>.js" type="text/javascript"></script>
                <?php else:?>
                    <script src="<?= base_url();?>js/<?= $javascript;?>.js" type="text/javascript"></script>
                <?php endif;?>    
            <?php else:?>
                <?php if(is_array($javascript)):?>    
                    <?php foreach($javascript as $js):?>
                        <?php if($js[0] === "/"):?>
                            <script src="<?= $js;?>.js" type="text/javascript"></script>
                        <?php else:?>
                            <script src="<?= base_url();?>js/<?= $js;?>.js" type="text/javascript"></script>
                        <?php endif;?>    
                    <?php endforeach;?>
                <?php endif;?>        
            <?php endif;?>        
        <?php endif;?>


        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/afui.custom.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/general.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/mapa.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/incidente.css">
        <?php if(isset($estilo)):?>
            <?php if(!is_array($estilo) && ($estilo != "")):?>
                <?php if($estilo[0] === "/"):?>
                    <link rel="stylesheet" type="text/css" href="<?= $estilo;?>.css">
                <?php else:?>
                    <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/<?= $estilo;?>.css">
                <?php endif;?>    
            <?php else:?>
                <?php if(is_array($estilo)):?>    
                    <?php foreach($estilo as $css):?>                    
                        <?php if($css[0] === "/"):?>
                            <link rel="stylesheet" type="text/css" href="<?= $css;?>.css">
                        <?php else:?>
                            <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/<?= $css;?>.css">
                        <?php endif;?>    
                    <?php endforeach;?>
                <?php endif;?>        
            <?php endif;?>        
        <?php endif;?>
        
        
        
    </head>
    <body>        
        <div id="afui">
            
            <div id="content">
                <div class='panel' id='main' selected='true'>
                    <header>
                        <a id="backButton" class="button backButton">Volver</a>
                        <a id="menubadge" onclick='$.ui.toggleSideMenu()' class='menuButton' style="float:left !important"></a>
                        <?php if(isset($titulo)):?>
                            <h1><?= $titulo;?></h1>
                        <?php else:?>    
                            <h1>Participación ciudadana</h1>
                        <?php endif;?>                     
                    </header>
                    
                    
                    
 
                    
                    
                    