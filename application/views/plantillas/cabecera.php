<!DOCTYPE html>
<html lang ="es">
    <head>
        <title>Participacion Ciudadana</title>
	<meta name="description" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                
        <script src="//cdn.app-framework-software.intel.com/2.1/appframework.min.js" type="text/javascript"></script>        
        <link rel="stylesheet" type="text/css" href="http://cdn.app-framework-software.intel.com/2.1/af.ui.css" />
        <link rel="stylesheet" type="text/css" href="http://cdn.app-framework-software.intel.com/2.1/icons.css" />
        <script type="text/javascript" charset="utf-8" src="http://cdn.app-framework-software.intel.com/2.1/appframework.ui.min.js"></script>    
        
        <script>
            $.ui.useInternalRouting = false;
            //$.ui.useOSThemes = true; 
            $.feat.nativeTouchScroll=true;
        </script>
        
        
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

        <?php if(isset($javascript)):?>
            <?php if(!is_array($javascript) && ($javascript != "")):?>
                <script src="<?= base_url();?>js/<?= $javascript;?>.js" type="text/javascript"></script>
            <?php else:?>
                <?php foreach($javascript as $js):?>
                    <script src="<?= base_url();?>js/<?= $js;?>.js" type="text/javascript"></script>
                <?php endforeach;?>
            <?php endif;?>        
        <?php endif;?>


        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/afui.custom.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/general.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/mapa.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/incidente.css">
        <?php if(isset($estilo)):?>
            <?php if(!is_array($estilo) && ($estilo != "")):?>
                <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/<?= $estilo;?>.css">
            <?php else:?>
                <?php foreach($estilo as $css):?>
                    <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/<?= $css;?>.css">
                <?php endforeach;?>
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
                        <h1>Participación ciudadana</h1>
                    </header>
                    
                    
                    
 
                    
                    
                    