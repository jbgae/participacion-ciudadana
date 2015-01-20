                    <?php if($this->uri->segment("1") == "historial" || $this->uri->segment("1") == "mapa"):?>
                    <footer>                        
                        <?= anchor("historial","Listado",array("class"=>"icon info") );?>
                        <?= anchor("mapa","Mapa",array("class"=>"icon location") );?>                            
                    </footer>
                    <?php endif;?>
                </div>
            </div>  
        </div>
    </body>
</html>
