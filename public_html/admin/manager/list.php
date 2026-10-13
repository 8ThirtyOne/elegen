<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();

if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
    $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
    if(!empty($username)){
        $isAdmin = $dbhelper->selectOne('SELECT isAdministrator FROM admin WHERE pkid = ?', 'i', $input);
        if($isAdmin == 1){
            $PageUrl = "/admin/manager/list";
            $PageCode = "000000";
            $bodyid = "manager";

            //Parameter
            $page = $webhelper->RequestFilter("page", 0, false);
            $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
            $filter = $webhelper->RequestFilter("filter", 0, false);
            $order = $webhelper->RequestFilter("order", 0, false);

            //check parameter
            if($webhelper->isNull($page)) $page = 1;
            if($webhelper->isNull($searchKey)) $searchKey = "";
            if($webhelper->isNull($filter)) $filter = 0;
            if($webhelper->isNull($order)) $order = 0;

            $Parameter = "&searchKey=$searchKey&filter=$filter&order=$order";
            $PageSize = 50;

            $sql = "SELECT pkid, id, status, isAdministrator, isEditor, isHR, regdate, logindate 
                    FROM admin WHERE 1=1 ";
            if($searchKey != ""){
                $sql .= " and (id like '%$searchKey%' or email like '%$searchKey%' or firstname like '%$searchKey%' or lastname like '%$searchKey%' )";
            }

            if($filter == 0){
                $currentChoice = 'ALL';
                $currentFilter = '#0';
                $secondChoice = 'Administrator';
                $secondFilter = '#1';
                $thirdChoice = 'Editor';
                $thirdFilter = '#2';

            }else{
                switch($filter){
                    case 1:
                        $sql .= " and isAdministrator = 1";
                        $currentChoice = 'Administrator';
                        $currentFilter = '#1';
                        $secondChoice = 'ALL';
                        $secondFilter = '#0';
                        $thirdChoice = 'Editor';
                        $thirdFilter = '#2';
                        break;
                    case 2:
                        $sql .= " and isEditor = 1";
                        $currentChoice = 'Editor';
                        $currentFilter = '#2';
                        $secondChoice = 'ALL';
                        $secondFilter = '#0';
                        $thirdChoice = 'Administrator';
                        $thirdFilter = '#1';
                        break;
                } 
            }

            if($order == 0)
                $sql .= " order by pkid desc ";

            if( $order == 1)
                $sql .= " order by id desc ";
            if( $order == 2)
                $sql .= " order by id asc ";

            if( $order == 3)
                $sql .= " order by regdate desc ";
            if( $order == 4)
                $sql .= " order by regdate asc ";

            if( $order == 5)
                $sql .= " order by logindate desc ";
            if( $order == 6)
                $sql .= " order by logindate asc ";

            $List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
            $pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
            $FirstPageCode = substr($PageCode, 0, 2);
            $SecodeCode = substr($PageCode, 2, 2);
            $ThirdCode = substr($PageCode, 4, 2);
        }else{
           header('Location: /admin/resources/literatures/list');
           exit; 
        }
    }else{
        header('Location: /admin/');
        exit;
    }
  }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ADMIN PORTAL | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
    <script type="text/javascript">
        function search(){
            document.searchFrm.submit();
        }
        
        
        function order(type){
            var f = document.searchFrm;

            if(type == 0){
                f.order.value = "0";
            }

            if(type == 1){
                if(f.order.value == "1")
                {
                    f.order.value = "2";
                }else
                {
                    f.order.value = "1";
                }
            }

            if(type == 3){
                if(f.order.value == "3")
                {
                    f.order.value = "4";
                }else
                {
                    f.order.value = "3";
                }
            }

            if(type == 5){
                if(f.order.value == "5")
                {
                    f.order.value = "6";
                }else
                {
                    f.order.value = "5";
                }
            }
            
            document.searchFrm.submit();
        }
    </script>
    
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

         <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <div id="search-data">

            <div id="search-form">
                <h2>Manager List</h2>
                <form name="searchFrm" method="get" action="/admin/manager/list">
                    <input type="hidden" name="order" value="<?php echo $order; ?>"/>
                    <input type="text" name="searchKey" value="<?php echo $searchKey; ?>"> 
                    <a href="javascript:search();" class="global-btn green-btn smooth-hover"><i class="fa-solid fa-magnifying-glass"></i></a>
                </form>
            </div>

            <div id="select-users">
                <h4>SHOW ONLY USERS WHERE</h4>
                <div class="select-box" id="filter">
                    <ul>
                        <li class="current"><a href="<?php echo $currentFilter; ?>"><?php echo $currentChoice; ?><i class="fa fa-chevron-circle-down"></i></a></a></li>
                        <li class="choice"><a href="<?php echo $secondFilter; ?>"><?php echo $secondChoice; ?></a></li>
                        <li class="choice"><a href="<?php echo $thirdFilter; ?>"><?php echo $thirdChoice; ?></a></li>
                    </ul>
                </div>

              </div>

              <div id="add-new">
               <a id="add-new-btn" class="global-btn green-btn smooth-hover" href="/admin/manager/registerFrm">ADD NEW</a>
               </div>

            </div>

            <div class="display-data" id="user-data">

            <table>
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th><a href="javascript:order(1);">Username<?php $show_order = $order == "1" ? "fa-sort-up" : ($order == "2" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
                    <th>Status</th>
                    <th>Roles</th>
                    <th><a href="javascript:order(3);">Member for<?php $show_order = $order == "3" ? "fa-sort-up" : ($order == "4" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
                    <th><a href="javascript:order(5);">Last access<?php $show_order = $order == "5" ? "fa-sort-up" : ($order == "6" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  if(!empty($List) && count($List) > 0){
                     $num; 
                     $i=0;
                     foreach($List as $row){
                         $pkid = $row['pkid'];
                         $id = $row['id'];
                         $num = $TotalCount - ($i++) - ($PageSize * ($page - 1));
                ?>
                    <tr id="user<?php echo $pkid; ?>">
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/manager/modifyFrm?pkid=$pkid&page=$page$Parameter'>$id</a>"; ?></td>
                        <td class="user-status"><?php $status = $row["status"] == 0 ? "blocked" : "active"; 
                                  echo $status;
                            ?></td>
                        <td>
                            <ul>
                                <?php $user = $row["isAdministrator"] == 0 ? "" : "<li><i class='fa-solid fa-circle-user'></i>Administrator</li>"; 
                                      echo $user;
                                ?>
                                <?php $user =  $row["isEditor"] == 0 ? "" : "<li><i class='fa-solid fa-circle-user'></i>Editor</li>"; 
                                      echo $user;
                                ?>
                                <?php $user =  $row["isHR"] == 0 ? "" : "<li><i class='fa-solid fa-circle-user'></i>HR</li>"; 
                                      echo $user;
                                ?>
                            </ul>
                        </td>
                        <td><?php echo $webhelper->HumanTiming($row["regdate"]); ?></td>
                        <td><?php echo $webhelper->HumanTiming($row["logindate"]); ?></td>
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/manager/modifyFrm?pkid=$pkid&page=$page$Parameter' title='edit'>"; ?><i class="fa-solid fa-edit"></i></a><span class="separator"> | </span><?php if($pkid != $input) echo "<a class='data-link smooth-hover delete-data' href='#$pkid' title='delete'>"; ?><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>
                <?php
                        }
                    }else{
                ?>
                    <tr>
                        <td colspan="6" align="center">no data found.</td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>

            <?php if(count($List) > 0) $webhelper->GetAdminPageHtml($pageList, $page, $PageUrl, $Parameter, $PageSize); ?>

            </div>

        </div>

     <div class="delete-box mfp-with-anim mfp-hide">
        <form method="post" name="deleteFrm" id="delete-buttons">
          <input type="hidden" name="pkid" id="delete-id" />        
          <input type="submit" name="create" value="YES" class='global-btn green-btn smooth-hover' id="yes-btn" tabindex="1" />
          <button class='global-btn' id="no-btn">NO</button>
         </form>
      </div>

      </div>

    </section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script>
$(function(){
    var selectBox = $('.select-box');
    $('.select-box .current').click(function(e){
        selectChoice($(this));
        //stop propagation cause of window click
        e.preventDefault();
    });

    $(window).click(function(e) {
      var link = $('.select-box li');
      selectBox.each(function(index){
        var box = this.id;
        //if clicked anywhere on window but dropbox link
        if(!link.is(e.target)){
           if($('#'+box).height() > 40){
            $('#'+box).animate({
               height: "40px"
              }, {
              duration: 200,
              specialEasing:{
              width: 'linear'
              }
            });
           }
        }
      });
    });

    $('.select-box .choice').click(function(e){
      e.preventDefault();
      var icon = $(document.createElement('i'));
      icon.attr('class','fa fa-chevron-circle-down');
      var choice = $(this).find('a').attr('href');
      var filter = choice.split("#").pop();
      $('.select-box .current').find('i').remove();
      $('.select-box .current')
       .removeClass('current')
       .addClass('choice')
       .insertAfter($(this));
       $(this).removeClass('choice').addClass('current');
       icon.appendTo('.current a');
       $('.select-box ul').prepend($(this));
       document.location.href = "/admin/manager/list?page="+<?php echo $page ?>+"&searchKey="+"<?php echo $searchKey; ?>"+"&filter="+filter+"&order="+<?php echo $order; ?>;
    });

    $('.delete-data').click(function(e){
        e.preventDefault();
        var deleteBox = $('.delete-box');
        $('.delete-box h4').remove();
        var href=$(this).attr('href');
        var id = href.split("#").pop();
        $('#delete-id').val(id);
        deleteBox.attr('id',id);
        var username = $('#user'+id+' .data-link').text();
        var warning = $(document.createElement('h4'));
        warning.text("Are you sure you want to delete user "+username);
        warning.insertBefore($('.delete-box #delete-buttons'));
        openDeleteBox(id);
    });

    $('#no-btn').click(function(e){
      $.magnificPopup.close();
    });

    $('#yes-btn').click(function(e){
          var id = $('#delete-id').val();
          var f = $('#delete-buttons');
          var query = f.serializeArray();          
          $.ajax({
           type: 'POST',
           url: '/admin/manager/delete', 
           data: query,
           success: function(data){
            if(data == 0){
              alert('Something went wrong. Try again');
             }
            else{
              $('#user'+id).fadeOut(function(){
                $(this).remove();
                $.magnificPopup.close();
               });
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
        });
        return false;
    });

    function openDeleteBox(id){
        $('.delete-data').magnificPopup({
           removalDelay:700,
           mainClass:'mfp-zoom-in',
           modal: true,
           callbacks:{
            open:function(){
                 $('html').css({'padding':'0','margin':'0'});
                 $('body').css({'padding':'0','margin':'0'});
            }
           }
        });
    }

    function selectChoice(elem){
        var $this = elem;
        var opened = $this.closest('div').find('.select-open').attr('id');
        if(opened){
          $('#'+opened).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
          $('#'+opened).removeClass('select-open');
        }
        var id = $this.closest('div').attr('id');
        var dropdownH = $('#'+id)[0].scrollHeight;

        if($('#'+id).height() > 40){
          $('#'+id).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
        }else{
          $('#'+id).animate({
             height: dropdownH+'px'
            }, {
            duration: 200,
            specialEasing:{
            width:'linear'
            }
          });
          $('#'+id).addClass('select-open');
        }
    }
});
</script>
</body>
</html>