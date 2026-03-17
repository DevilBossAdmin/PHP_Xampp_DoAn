<div class="catagories-side-menu">
        <!-- Close Icon -->
        <div id="sideMenuClose">
            <i class="ti-close"></i>
        </div>
        <!--  Side Nav  -->
	        <div class="nav-side-menu">
	            <div class="menu-list">
	                <h6>Danh mục</h6>
	                <ul id="menu-content" class="menu-content collapse out">
	                    <?php
	                        // Render động danh mục sản phẩm từ DB
	                        $loaisanphams = DP::run_query("select id, ten_loai_san_pham from loaisanphams where da_xoa = 0", [], 2);
	                        foreach($loaisanphams as $loai) {
	                    ?>
	                        <li>
	                            <!-- Link nhảy xuống khu vực 'Danh Mục' và filter theo category -->
	                            <a href="#danh-muc" class="js-filter-category" data-filter=".<?=$loai['id'];?>a"><?=$loai['ten_loai_san_pham'];?></a>
	                        </li>
	                    <?php } ?>
	                </ul>
	            </div>
	        </div>
    </div>