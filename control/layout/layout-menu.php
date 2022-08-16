<ul class="clearfix">
    <li ><a href="index.php">
        <i class="icon-home"></i>
        <span>Dashboard</span>
        </a>
    </li> 
    <?php
        $listaI = new Category();				
		$listaI->addWhere('enabled=1');
        $listaI->addOrder('OrderId Asc');
        $listaI->loadList();
        $listaI->pTreeCategory('accordion');
    ?>               
</ul>