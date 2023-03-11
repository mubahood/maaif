<?php


class kmu
{


    public static function getAllLanguagesList(){

        $sql = database::performQuery("SELECT * FROM km_language ORDER BY name ASC");
        $content = '';
        while($data = $sql->fetch_assoc()){

            $content .='<option value="'.$data['id'].'">'.strtoupper(strtolower($data['name'])).'</option>';
        }

        return $content;
    }




    public static function countChildrenMenuBuilder($id){
        $sql = database::performQuery("SELECT * FROM km_category WHERE parent_id=$id");

        return $sql->num_rows;
    }

    public static function KMEntreprizeListBuilder($id)
    {
        $content = '';

        $sql = database::performQuery("SELECT * FROM km_category WHERE id=$id");
        while($data=$sql->fetch_assoc()) {


            $content .= '<optgroup label="'.$data['name'].'">';

            $getCount = self::countChildrenMenuBuilder($id);

            //There are some children, build menu
            //First Level Accordian here
            if($getCount > 0){

                $sqlb = database::performQuery("SELECT * FROM km_category WHERE parent_id=$id");
                while($datab=$sqlb->fetch_assoc()) {

                    $getCountb = self::countChildrenMenuBuilder($datab['id']);

                    //There are some children, build menu
                    //Second Level Accordian here
                    if($getCountb > 0) {

                        $content .= '<optgroup label="'.$datab['name'].'"></optgroup>';


                        $sqlc = database::performQuery("SELECT * FROM km_category WHERE parent_id=$datab[id]");
                        while ($datac = $sqlc->fetch_assoc()) {
                            $content .= '<optgroup label="'.$datac['name'].'"></optgroup>';
                        }

                        $content .='</optgroup></optgroup>';
                    }
                    //No children, create link to follow
                    else
                    {
                        $content .='<option value="'.$datab['id'].'">'.strtoupper(strtolower($datab['name'])).'</option>';

                    }





                }

            }



            $content .='</optgroup>';

        }

        return $content;



    }



    public static function getAllEntreprizes($parent_id)
    {

        $result = database::performQuery("select * from km_category where parent_id='$parent_id'");
        $content = '';
        //There are results
        if($result->num_rows >0){

            while ($row = $result->fetch_assoc()) {
                $content .= '<optgroup label="'.$row['name'].'">';
                $content .= self::getAllEntreprizes($row['id']);

            }

        }
       else {
            while ($data = $result->fetch_assoc()) {
                $content .= '<option value="' . $data['id'] . '">' . strtoupper(strtolower($data['name'])) . '</option>';
            }
        }
        $content .='</optgroup>';
        return $content;
    }

    public static function getKMUDataFE()
    {

        $content = '<div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Filter Content</strong></p>
                                            <!-- form -->
                                                <form action="#" method="get">

                                                <div class="row"> 
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Keyword</label>
                                                        <input type="text" name="keyword" placeholder="Type Keyword(s)" class="form-control text-3 h-auto py-2">
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Enterperize/Approach</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="entreprize" required>
                                                            <option value="0" selected="selected">All Entreprizes/Approaches</option>
                                                            <optgroup>Crops</optgroup>
                                                            '.self::KMEntreprizeListBuilder(4).'        
                                                            '.self::KMEntreprizeListBuilder(5).'    
                                                            '.self::KMEntreprizeListBuilder(6).'    
                                                            '.self::KMEntreprizeListBuilder(7).'    
                                                            '.self::KMEntreprizeListBuilder(8).'    
                                                            '.self::KMEntreprizeListBuilder(9).'                                                
                                                            '.self::KMEntreprizeListBuilder(10).'                                               
                                                            '.self::KMEntreprizeListBuilder(11).'   
                                                            <optgroup>Livestock</optgroup>
                                                            '.self::KMEntreprizeListBuilder(2).'    
                                                            '.self::KMEntreprizeListBuilder(201).'  
                                                            <optgroup>Fish/Aquaculture</optgroup>
                                                            '.self::KMEntreprizeListBuilder(3).'    
                                                            <optgroup>Other Approaches</optgroup>
                                                            '.self::KMEntreprizeListBuilder(103).'                                                      
                                                            '.self::KMEntreprizeListBuilder(104).'                                                      
                                                            '.self::KMEntreprizeListBuilder(106).'                                                      
                                                            '.self::KMEntreprizeListBuilder(108).'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Language</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="language" >
                                                          <option value="0" selected="selected">Select Language</option>
                                                            '.self::getAllLanguagesList().'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Content Type</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="content_type" required>
                                                            <option value="1" selected="selected">Video</option>
                                                            <option value="2">Manuals</option>
                                                            <option value="3">Report</option>
                                                            <option value="4">Briefing Papers</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <input type="hidden" name="action" value="getKMUContentSearch">
                                                        <input type="submit" value="Filter Content" class="btn btn-primary btn-modern" style="margin-top: 1.9rem !important" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>';

        //Form has been set, display data else default to original
        if (isset($_REQUEST['ent'])) {


            //TODO Display results here paginated




            } else {
                //TODO Display default page with the latest videos

            $content .='
            			<div id="examples" class="container py-2">

		                    <div class="row">
		                        <div class="col-md-8">

		                        	<div class="card">
				                      <div class="card-body">
				                        <h4 class="card-title">Latest Videos</h4>
				                        <div class="row">
                                            <div class="col">
                                                <div class="blog-posts">

                                                    <div class="row">

                                                        <!-- videos -->
                                                        '.self::getLatestVideosMore().'

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
				                      </div>
				                    </div>

		                        </div>
		                        <div class="col-md-4">
		                            '.dashboard::getAsideKMUMenu().'
		                        </div>
		                    </div>                   

		                </div>';

            }

            $styles = '
                <style type="text/css">
                    .card.categories {
                          /*height: 1172px;*/
                          margin: 10px auto;
                        }
                    .card .scrollable{
                          overflow-y: auto;
                          max-height: 1102px;
                            }
                    .tree,
                    .tree ul {
                      margin: 0;
                      padding: 0;
                      list-style: none;
                    }

                    .tree ul {
                      margin-left: 0.4em;
                      position: relative;
                    }

                    .tree ul ul {
                      margin-left: .3em;
                    }

                    .tree ul:before {
                      content: "";
                      display: block;
                      width: 0;
                      position: absolute;
                      top: 0;
                      bottom: 0;
                      left: 0;
                      border-left: 1px solid;
                    }

                    .tree li {
                      margin: 0;
                      padding: 0 0.8em;
                      line-height: 2em;
                      color: #555;
                      font-weight: 700;
                      position: relative;
                    }

                    .tree ul li:before {
                      content: "";
                      display: block;
                      width: 10px;
                      height: 0;
                      border-top: 1px solid;
                      margin-top: -1px;
                      position: absolute;
                      top: 1em;
                      left: 0;
                    }

                    .tree ul li:last-child:before {
                      background: #fff;
                      height: auto;
                      top: 1em;
                      bottom: 0;
                    }

                    .indicator {
                      /*margin-right: 5px;*/
                      font-size: 9px;
                    }

                    .tree li a {
                      text-decoration: none;
                      color: #06f;
                    }

                    .tree li button,
                    .tree li button:active,
                    .tree li button:focus {
                      text-decoration: none;
                      color: #555;
                      border: none;
                      background: transparent;
                      margin: 0px 0px 0px 0px;
                      padding: 0px 0px 0px 0px;
                      outline: 0;
                    }

                    .tree ul,
                    .tree li {
                      cursor: pointer;
                    }

                    .tree .btn-default.active {
                      background-color: #1c90c1;
                      color: #fff;
                    }

                    .tree .btn-default {
                      background-color: #eee;
                    }

                    .tree .fa-info-circle {
                      color: #1c90c1;
                    }

                    .tree .categories {
                        margin-right: 10px;
                        font-size: 20px;
                    }

                    .tree ul li ul li .indicator {
                        margin-right: 5px !important;
                    }
                </style> ';

                $scripts = '
                    <script>
                        /* 
                        =========
                        TREEVIEW 
                        =========
                        */

                        $.fn.extend({
                          treed: function() {
                            return this.each(function() {
                              //initialize each of the top levels
                              var tree = $(this);
                              tree.addClass("tree");
                              tree.find(\'li\').has("ul").each(function() {
                                var branch = $(this); //li with children ul
                                branch.prepend("<i class=\'indicator fas fa-plus\'></i>");
                                branch.addClass(\'branch\');
                                branch.on(\'click\', function(e) {
                                  if (this == e.target) {
                                    var icon = $(this).children(\'i:first\');
                                    icon.toggleClass("fa-minus fa-plus");
                                    $(this).children().children().toggle();
                                  }
                                })
                                branch.children().children().toggle();
                              });
                              //fire event from the dynamically added icon
                              $(\'.branch .indicator\').on(\'click\', function() {
                                $(this).closest(\'li\').click();
                              });
                              //fire event to open branch if the li contains an anchor instead of text
                              $(\'.branch a\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                // e.preventDefault();
                              });
                              //fire event to open branch if the li contains a button instead of text
                              $(\'.branch button\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                e.preventDefault();
                              });
                            });
                          }
                        });

                        $(\'.tree\').treed();
                    </script>';

	        return [
	        	'content' => $content,
	        	'styles' => $styles,
	        	'scripts' => $scripts
	        ];
    }

    public static function getKMUDetails($id)
    {
        if($id != 0){
        $sql= database::performQuery("SELECT * FROM km_category WHERE id=$id");
        return $sql->fetch_assoc();
        }
        else {
            return ['id'=>0,'name'=>'All Enteprizes'];
        }

    }


    public static function countCategoryVideos($id)
    {

            $sql= database::performQuery("SELECT * FROM kmu_has_km_category WHERE km_category_id=$id");
            return $sql->num_rows;


    }


    public static function getKMUDataFEByCategory()
    {
        $content = '<div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Filter Videos</strong></p>
                                            <!-- form -->
                                                <form action="#" method="get">

                                                <div class="row"> 
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Keyword</label>
                                                        <input type="text" name="keyword" placeholder="Type Keyword(s)" class="form-control text-3 h-auto py-2">
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Enterperize/Approach</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="entreprize" required>
                                                            <option value="0" selected="selected">All Entreprizes/Approaches</option>
                                                            <optgroup>Crops</optgroup>
                                                            '.self::KMEntreprizeListBuilder(4).'        
                                                            '.self::KMEntreprizeListBuilder(5).'    
                                                            '.self::KMEntreprizeListBuilder(6).'    
                                                            '.self::KMEntreprizeListBuilder(7).'    
                                                            '.self::KMEntreprizeListBuilder(8).'    
                                                            '.self::KMEntreprizeListBuilder(9).'                                                
                                                            '.self::KMEntreprizeListBuilder(10).'                                               
                                                            '.self::KMEntreprizeListBuilder(11).'   
                                                            <optgroup>Livestock</optgroup>
                                                            '.self::KMEntreprizeListBuilder(2).'    
                                                            '.self::KMEntreprizeListBuilder(201).'  
                                                            <optgroup>Fish/Aquaculture</optgroup>
                                                            '.self::KMEntreprizeListBuilder(3).'    
                                                            <optgroup>Other Approaches</optgroup>
                                                            '.self::KMEntreprizeListBuilder(103).'                                                      
                                                            '.self::KMEntreprizeListBuilder(104).'                                                      
                                                            '.self::KMEntreprizeListBuilder(106).'                                                      
                                                            '.self::KMEntreprizeListBuilder(108).'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Language</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="language" >
                                                          <option value="0" selected="selected">Select Language</option>
                                                            '.self::getAllLanguagesList().'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Content Type</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="content_type" required>
                                                            <option value="1" selected="selected">Video</option>
                                                            <option value="2">Manuals</option>
                                                            <option value="3">Report</option>
                                                            <option value="4">Briefing Papers</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <input type="hidden" name="action" value="getKMUContentSearch">
                                                        <input type="submit" value="Filter Content" class="btn btn-primary btn-modern" style="margin-top: 1.9rem !important" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>';

        //Category has been set, filter results here
        if (isset($_REQUEST['id'])) {

            $category_id =  $_REQUEST['id'];
            $countCatVideos = self::countCategoryVideos($category_id);
            $cat = kmu::getKMUDetails($_REQUEST['id']);


            $content .='<div id="examples" class="container py-2">

		                    <div class="row">
		                        <div class="col-md-8">

		                        	<div class="card">
				                      <div class="card-body">
				                        <h4 class="card-title">Latest Content on  '.$cat['name'].' - '.$countCatVideos.' new videos</h4>
			                            '.self::getLatestVideosByCategory($category_id).'
				                      </div>
				                    </div>

		                        </div>
		                        <div class="col-md-4">
		                            '.dashboard::getAsideKMUMenu().'
		                        </div>
		                    </div>                   

		                </div>

		                <!--begin::Container-->';
        }

        $styles = '
                <style type="text/css">
                    .card.categories {
                          /*height: 1172px;*/
                          margin: 10px auto;
                        }
                    .card .scrollable{
                          overflow-y: auto;
                          max-height: 1102px;
                            }
                    .tree,
                    .tree ul {
                      margin: 0;
                      padding: 0;
                      list-style: none;
                    }

                    .tree ul {
                      margin-left: 0.4em;
                      position: relative;
                    }

                    .tree ul ul {
                      margin-left: .3em;
                    }

                    .tree ul:before {
                      content: "";
                      display: block;
                      width: 0;
                      position: absolute;
                      top: 0;
                      bottom: 0;
                      left: 0;
                      border-left: 1px solid;
                    }

                    .tree li {
                      margin: 0;
                      padding: 0 0.8em;
                      line-height: 2em;
                      color: #555;
                      font-weight: 700;
                      position: relative;
                    }

                    .tree ul li:before {
                      content: "";
                      display: block;
                      width: 10px;
                      height: 0;
                      border-top: 1px solid;
                      margin-top: -1px;
                      position: absolute;
                      top: 1em;
                      left: 0;
                    }

                    .tree ul li:last-child:before {
                      background: #fff;
                      height: auto;
                      top: 1em;
                      bottom: 0;
                    }

                    .indicator {
                      /*margin-right: 5px;*/
                      font-size: 9px;
                    }

                    .tree li a {
                      text-decoration: none;
                      color: #06f;
                    }

                    .tree li button,
                    .tree li button:active,
                    .tree li button:focus {
                      text-decoration: none;
                      color: #555;
                      border: none;
                      background: transparent;
                      margin: 0px 0px 0px 0px;
                      padding: 0px 0px 0px 0px;
                      outline: 0;
                    }

                    .tree ul,
                    .tree li {
                      cursor: pointer;
                    }

                    .tree .btn-default.active {
                      background-color: #1c90c1;
                      color: #fff;
                    }

                    .tree .btn-default {
                      background-color: #eee;
                    }

                    .tree .fa-info-circle {
                      color: #1c90c1;
                    }

                    .tree .categories {
                        margin-right: 10px;
                        font-size: 20px;
                    }

                    .tree ul li ul li .indicator {
                        margin-right: 5px !important;
                    }
                </style> ';

                $scripts = '
                    <script>
                        /* 
                        =========
                        TREEVIEW 
                        =========
                        */

                        $.fn.extend({
                          treed: function() {
                            return this.each(function() {
                              //initialize each of the top levels
                              var tree = $(this);
                              tree.addClass("tree");
                              tree.find(\'li\').has("ul").each(function() {
                                var branch = $(this); //li with children ul
                                branch.prepend("<i class=\'indicator fas fa-plus\'></i>");
                                branch.addClass(\'branch\');
                                branch.on(\'click\', function(e) {
                                  if (this == e.target) {
                                    var icon = $(this).children(\'i:first\');
                                    icon.toggleClass("fa-minus fa-plus");
                                    $(this).children().children().toggle();
                                  }
                                })
                                branch.children().children().toggle();
                              });
                              //fire event from the dynamically added icon
                              $(\'.branch .indicator\').on(\'click\', function() {
                                $(this).closest(\'li\').click();
                              });
                              //fire event to open branch if the li contains an anchor instead of text
                              $(\'.branch a\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                // e.preventDefault();
                              });
                              //fire event to open branch if the li contains a button instead of text
                              $(\'.branch button\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                e.preventDefault();
                              });
                            });
                          }
                        });

                        $(\'.tree\').treed();
                    </script>';


        return [
        	'content' => $content,
        	'styles' => $styles,
        	'scripts' => $scripts
        ];
    }


    public static function getLatestVideosMore(){

        $sql = database::performQuery("SELECT * FROM kmu ORDER BY RAND() LIMIT 6");
        $content = '';
        while($data=$sql->fetch_assoc()){

            $url = dashboard::prepYTURL($data['video']);


            $content .='
            			<div class="col-md-6 col-lg-6">
                            <article class="post post-medium border-0 pb-0 mb-5">
                                <div class="post-image">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="'.$url.'" title="'.$data['title'].'" allowfullscreen="" width="640" height="360"></iframe>
                                    </div>
                                </div>

                                <div class="post-content">

                                    <h2 class="font-weight-semibold text-4 line-height-6 mt-3 mb-2"><a href="#">'.$data['title'].'</a></h2>
                                    <p>'.substr($data['description'],0,200).'</p>

                                    <div class="post-meta">
                                        <span><i class="far fa-user"></i> By <a href="#">'.$data['produced_by'].'</a> </span>
                                        <span><i class="far fa-clock"></i> <a href="#">'.date("Y-m-d",strtotime($data['created'])).'</a></span>
                                    </div>

                                </div>
                            </article>
                        </div>';

        }
        return $content;
    }

    public static function getLatestVideosByCategory($id){

        //Paginate Results here

        //Main query
        $pages = new Paginator;
        $pages->default_ipp = 10;
        $sql_forms = database::performQuery("SELECT * FROM kmu,kmu_has_km_category  WHERE kmu.id=kmu_has_km_category.kmu_id AND km_category_id=$id");
        $pages->items_total = $sql_forms->num_rows;
        $pages->mid_range = 7;
        $pages->paginate();


        $result	=	database::performQuery("SELECT * FROM kmu,kmu_has_km_category  WHERE kmu.id=kmu_has_km_category.kmu_id AND km_category_id=$id ORDER BY id ASC ".$pages->limit." ");


        $content = '<div class="row">
                            <div class="col-12">
                            	<div class="blog-posts">';

		    	if($pages->items_total>0){
            while($data  =   $result->fetch_assoc()){

                $url = dashboard::prepYTURL($data['video']);

                $dataz ='
                			<div class="row mb-3">
							    <div class="col-lg-5">
							        <div class="post-image">
							            <div class="ratio ratio-16x9">
							                <iframe src="'.$url.'" title="'.$data['title'].'" allowfullscreen="" width="640" height="360"></iframe>
							                	<!-- <iframe width="330" height="175" src="'.$url.'" title="'.$data['title'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
							            </div>
							        </div>
							    </div>
							    <div class="col-lg-7">
							        <div class="post-content">
							            <h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2"><a href="#">'.$data['title'].'</a></h2>
							            <p class="mb-0">'.substr($data['description'],0,200).'</p>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="col">
							        <div class="post-meta">
							            <span><i class="far fa-calendar-alt"></i> '.date("Y-m-d",strtotime($data['created'])).' </span>
							            <span><i class="far fa-user"></i> By <a href="#">'.$data['produced_by'].'</a> </span>
							        </div>
							    </div>
							</div>';

                $content .='<article class="post post-medium">'.$dataz.'</article>';

            }
        }
		        
		        
$content .='</div>
				</div>
					</div>';

 $content .= '<div class="row marginTop">
                <div class="col-sm-12 paddingLeft pagerfwt">';

        if($pages->items_total > 0) {
            $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
            $content.= '<td>'.$pages->display_items_per_page().'</td>';
            $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
        }
        $content.=' </div>
                  </div>';






        return $content;
    }



    public static function getKMUDataFEBySearch()
    {
        $content = '<div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Filter Videos</strong></p>
                                            <!-- form -->
                                                <form action="#" method="get">

                                                <div class="row"> 
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Keyword</label>
                                                        <input type="text" name="keyword" placeholder="Type Keyword(s)" class="form-control text-3 h-auto py-2">
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label mb-1 text-2">Enterperize/Approach</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="entreprize" required>
                                                            <option value="0" selected="selected">All Entreprizes/Approaches</option>
                                                            <optgroup>Crops</optgroup>
                                                            '.self::KMEntreprizeListBuilder(4).'		
									                        '.self::KMEntreprizeListBuilder(5).'	
									                        '.self::KMEntreprizeListBuilder(6).'	
									                        '.self::KMEntreprizeListBuilder(7).'	
									                        '.self::KMEntreprizeListBuilder(8).'	
									                        '.self::KMEntreprizeListBuilder(9).'												
									                        '.self::KMEntreprizeListBuilder(10).'												
									                        '.self::KMEntreprizeListBuilder(11).'	
									                        <optgroup>Livestock</optgroup>
									                        '.self::KMEntreprizeListBuilder(2).'	
															'.self::KMEntreprizeListBuilder(201).'	
									                        <optgroup>Fish/Aquaculture</optgroup>
									                        '.self::KMEntreprizeListBuilder(3).'	
									                        <optgroup>Other Approaches</optgroup>
									                        '.self::KMEntreprizeListBuilder(103).'														
									                        '.self::KMEntreprizeListBuilder(104).'														
									                        '.self::KMEntreprizeListBuilder(106).'														
									                        '.self::KMEntreprizeListBuilder(108).'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Language</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="language" >
                                                          <option value="0" selected="selected">Select Language</option>
                                                            '.self::getAllLanguagesList().'
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label class="form-label mb-1 text-2">Content Type</label>
                                                        <select class="form-control form-select text-3 h-auto py-2" name="content_type" required>
                                                            <option value="1" selected="selected">Video</option>
                                                            <option value="2">Manuals</option>
                                                            <option value="3">Report</option>
                                                            <option value="4">Briefing Papers</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <input type="hidden" name="action" value="getKMUContentSearch">
                                                        <input type="submit" value="Filter Content" class="btn btn-primary btn-modern" style="margin-top: 1.9rem !important" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>';

        //Category has been set, filter results here
        if (isset($_REQUEST['entreprize'])) {


            $keyword = $_REQUEST['keyword'];
            $category_id =  $_REQUEST['entreprize'];
            $language = $_REQUEST['language'];
            $type = $_REQUEST['content_type'];
            $countCatVideos = self::countCategoryVideos($category_id);
            $cat = kmu::getKMUDetails($_REQUEST['entreprize']);

            $content .='<div id="examples" class="container py-2">

		                    <div class="row">
		                        <div class="col-md-8">

		                        	<div class="card">
				                      <div class="card-body">
				                        <h4 class="card-title">Latest Content on  '.$cat['name'].' - '.$countCatVideos.' new videos</h4>
			                            '.self::getLatestVideosBySearch($category_id,$keyword,$language,$type).'
				                      </div>
				                    </div>

		                        </div>
		                        <div class="col-md-4">
		                            '.dashboard::getAsideKMUMenu().'
		                        </div>
		                    </div>                   

		                </div>

		                <!--begin::Container-->';
        }

        $styles = '
                <style type="text/css">
                    .card.categories {
                          /*height: 1172px;*/
                          margin: 10px auto;
                        }
                    .card .scrollable{
                          overflow-y: auto;
                          max-height: 1102px;
                            }
                    .tree,
                    .tree ul {
                      margin: 0;
                      padding: 0;
                      list-style: none;
                    }

                    .tree ul {
                      margin-left: 0.4em;
                      position: relative;
                    }

                    .tree ul ul {
                      margin-left: .3em;
                    }

                    .tree ul:before {
                      content: "";
                      display: block;
                      width: 0;
                      position: absolute;
                      top: 0;
                      bottom: 0;
                      left: 0;
                      border-left: 1px solid;
                    }

                    .tree li {
                      margin: 0;
                      padding: 0 0.8em;
                      line-height: 2em;
                      color: #555;
                      font-weight: 700;
                      position: relative;
                    }

                    .tree ul li:before {
                      content: "";
                      display: block;
                      width: 10px;
                      height: 0;
                      border-top: 1px solid;
                      margin-top: -1px;
                      position: absolute;
                      top: 1em;
                      left: 0;
                    }

                    .tree ul li:last-child:before {
                      background: #fff;
                      height: auto;
                      top: 1em;
                      bottom: 0;
                    }

                    .indicator {
                      /*margin-right: 5px;*/
                      font-size: 9px;
                    }

                    .tree li a {
                      text-decoration: none;
                      color: #06f;
                    }

                    .tree li button,
                    .tree li button:active,
                    .tree li button:focus {
                      text-decoration: none;
                      color: #555;
                      border: none;
                      background: transparent;
                      margin: 0px 0px 0px 0px;
                      padding: 0px 0px 0px 0px;
                      outline: 0;
                    }

                    .tree ul,
                    .tree li {
                      cursor: pointer;
                    }

                    .tree .btn-default.active {
                      background-color: #1c90c1;
                      color: #fff;
                    }

                    .tree .btn-default {
                      background-color: #eee;
                    }

                    .tree .fa-info-circle {
                      color: #1c90c1;
                    }

                    .tree .categories {
                        margin-right: 10px;
                        font-size: 20px;
                    }

                    .tree ul li ul li .indicator {
                        margin-right: 5px !important;
                    }
                </style> ';

                $scripts = '
                    <script>
                        /* 
                        =========
                        TREEVIEW 
                        =========
                        */

                        $.fn.extend({
                          treed: function() {
                            return this.each(function() {
                              //initialize each of the top levels
                              var tree = $(this);
                              tree.addClass("tree");
                              tree.find(\'li\').has("ul").each(function() {
                                var branch = $(this); //li with children ul
                                branch.prepend("<i class=\'indicator fas fa-plus\'></i>");
                                branch.addClass(\'branch\');
                                branch.on(\'click\', function(e) {
                                  if (this == e.target) {
                                    var icon = $(this).children(\'i:first\');
                                    icon.toggleClass("fa-minus fa-plus");
                                    $(this).children().children().toggle();
                                  }
                                })
                                branch.children().children().toggle();
                              });
                              //fire event from the dynamically added icon
                              $(\'.branch .indicator\').on(\'click\', function() {
                                $(this).closest(\'li\').click();
                              });
                              //fire event to open branch if the li contains an anchor instead of text
                              $(\'.branch a\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                // e.preventDefault();
                              });
                              //fire event to open branch if the li contains a button instead of text
                              $(\'.branch button\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                e.preventDefault();
                              });
                            });
                          }
                        });

                        $(\'.tree\').treed();
                    </script>';


        return [
        	'content' => $content,
        	'styles' => $styles,
        	'scripts' => $scripts
        ];
    }

    public static function getLatestVideosBySearch($entreprize, $keyword,$language,$type){


        //Check Entreprizes
        if(isset($entreprize) && $entreprize ==0)
        {
            $ent = '';
        }
        else
        {
            $ent = " AND km_category_id=$entreprize ";
        }


        //Check Languages
        if(isset($language) && $language ==0)
        {
            $lang = '';
        }
        else
        {
            $lang = " AND km_language_id=$language ";
        }



        //Check Keywords set
        if(isset($keyword))
        {
           // $keywd = "AND title LIKE '%$keyword%' ";
            $keywd = "AND MATCH(title) AGAINST ('$keyword' IN BOOLEAN MODE) ";
        }
        else
        {
            $keywd = ' ';
        }



        //Check Content Type
        if(isset($type) && $type ==0)
        {
            $type = '';
        }
        else
        {
            $type = " AND km_content_category_id=$type ";
        }


        //Main query
        $pages = new Paginator;
        $pages->default_ipp = 10;
        $sql_forms = database::performQuery("SELECT * FROM kmu,kmu_has_km_category,km_language  WHERE km_language.id = kmu.km_language_id AND kmu.id=kmu_has_km_category.kmu_id $keywd $ent $lang $type");
        $pages->items_total = $sql_forms->num_rows;
        $pages->mid_range = 7;
        $pages->paginate();


        $result	=	database::performQuery("SELECT * FROM kmu,kmu_has_km_category,km_language  WHERE km_language.id = kmu.km_language_id AND  kmu.id=kmu_has_km_category.kmu_id  $keywd $ent $lang $type ORDER BY kmu.id ASC ".$pages->limit." ");



        $content =' <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                    
                                 
                                    </div>
                                        <table  id="basic-datatable" class="table table-bordered table-striped ">
                                                  <tbody>';


        if($pages->items_total>0){
            while($data  =   $result->fetch_assoc()){

                $url = dashboard::prepYTURL($data['video']);

                $dataz ='<!--begin::Col-->
											<div class="col-md-12">
												<!--begin::Feature post-->
												<div class="card-xl-stretch me-md-12">
													<!--begin::Image-->
													
													<div class="row">
													<div class="col-md-6">
													<iframe width="330" height="175" src="'.$url.'" title="'.$data['title'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
													</div>
													
													<div class="col-md-6">
													<!--end::Image-->
													<!--begin::Body-->
													<div class="m-0">
														<!--begin::Title-->
														<a href="#" class="fs-4 text-dark fw-bolder text-hover-primary text-dark lh-base">'.$data['title'].'</a>
														<!--end::Title-->
														<!--begin::Text-->
														<div class="fw-bold fs-5 text-gray-600 text-dark my-4">'.substr($data['description'],0,200).'</div>
														<!--end::Text-->
														<!--begin::Content-->
														<div class="fs-6 fw-bolder">
															<!--begin::Author-->
															<a href="#" class="text-gray-700 text-hover-primary">'.$data['produced_by'].'</a>
															<!--end::Author-->
															<!--begin::Date-->
															<span class="text-muted">on '.date("Y-m-d",strtotime($data['created'])).'</span>
															<!--end::Date-->
														</div>
														<!--end::Content-->
													</div>
													
													</div>
													
													</div>
													<!--end::Body-->
												</div>
												<!--end::Feature post-->
											</div>
											<!--end::Col-->';

                $content .='<tr>
                                        <td>'.$dataz.'</td>
                                       
                                        
                                    </tr>';

            }
        }
        $content.='</tbody>
		                                          </table>
                                           
                                     <div class="clearfix"></div>

                                     <div class="row marginTop">
                                            <div class="col-sm-12 paddingLeft pagerfwt">';

        if($pages->items_total > 0) {
            $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
            $content.= '<td>'.$pages->display_items_per_page().'</td>';
            $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
        }
        $content.=' </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';






        return $content;
    }

    public static function manageKMU()
    {


        //Display add button
        switch($_SESSION['user']['user_category_id']){

            case 5:
            case 15:
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:
                $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addKMU">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add Knowledge Management Content</button>
                    </a>
                    <br />
                    <br />
                    </div>';
                break;

            default:
                $addd_btn  = '';
                break;
        }

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>                                                
                                                <th>Title</th>                                                
                                                <th>Description</th>
                                                <th>Content Type</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getUserManageList().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                              <th></th>                                                
                                              <th>Title</th>                                                
                                                <th>Description</th>
                                                <th>Content Type</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;
    }



    public static function getUserManageList(){



        $sql = database::performQuery("SELECT * FROM kmu ORDER BY id ASC");

        $rt =  '';
        while($data=$sql->fetch_assoc()){
            $video = dashboard::prepYTURL($data['video']);

                $addd_btn2 = '   <a href="'.ROOT.'/?action=deleteKMU&id='.$data['id'].'">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger"><i class="fas fa-times"></i> Delete</button></a> ';

                $content_category = 'Text';
                if($data['km_content_category_id'] == 1)
                    $content_category = 'Video';



            $rt .='<tr>
                                                <td>
                                                	
													<iframe width="330" height="175" src="'.$video.'" title="'.$data['title'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
												
                                                </td>
                                                <td>'.$data['title'].'</td>
                                                <td>'.substr($data['description'],0,150).'</td>
                                                <td>'.$content_category.'</td>
                                                <td>'.$data['created'].'</td>
                                                <td>
                                              
                                                <a href="'.ROOT.'/?action=#&id='.$data['id'].'"><button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info"> <i class="far fa-newspaper"></i> View Frontend</button></a>
                                                   '.$addd_btn2.'
                                                 
                                                
                                                </td>
                                            </tr>';
        }

        return $rt;
    }

}