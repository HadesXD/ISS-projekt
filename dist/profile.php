<?php
include_once 'utils/php/design/header.php';
include_once 'utils/php/session/session.php';
include_once 'utils/php/session/database.php';
include_once 'alert.php';
?>

<script>
    let tab = document.querySelector("#profile");
        tab.setAttribute('class', 'on');
</script>

<div id="content">
    <div id="left">
      <h2>My Profile</h2>
      
<?php
    $sql = "SELECT * FROM profile_photos pp 
        INNER JOIN users u ON pp.id_user = u.id_user WHERE pp.id_user=? 
        ORDER BY id_profile_photo DESC LIMIT 1";

    $stmt=$pdo->prepare($sql);
    $stmt->execute([$_SESSION['id_user']]);  
        
    while ($picture = $stmt->fetch()) {
        echo '<img src="'.$picture['url'].'" width="100px" /> ';
    }

    echo '<p>Name: '.$_SESSION['full_name'].'</p>';
    echo '<p>Email: '.$_SESSION['email'].'</p>';
    echo ($_SESSION['rank'] == 0)? '<p>Status: user</p>' : '<p>Status: admin</p>';
?>

    </div>
    <div id="right">
      <h3>Useful links</h3>
      <ul class="links">
        <li><a href="#" onclick="callEdit()">Edit information</a></li>
        <li><form action="utils/php/logic/picture_insert.php" method="POST" enctype="multipart/form-data"><a>Izberi sliko:
        <input type="file" name="fileToUpload" id="fileToUpload" /><input type="submit" value="Naloži" name="submit" /></a></form></li>
        <li><a href="utils/php/logic/user_delete.php">Delete account?</a></li>
        <li><a href="utils/php/logic/logout.php">Logout</a></li>
      </ul>
    </div>

<!-- we need this to close the modal -->
<div id="overlay"></div> 

<!-- the modal --> 
<div class="modal" id="myModal">
    <div class="modal-header">
    <div class="title">Edit your user information!</div>
    <button data-close-button class="close-button">&times;</button>
    </div>
    <div class="modal-body">
    <form action="utils/php/logic/user_update.php" method="post">
        <input id="first_name" name="first_name" class="modalInput" type="text" placeholder="First Name"/><br/><br/>
        <input id="last_name" name="last_name" class="modalInput" type="text" placeholder="Last Name"/><br/><br/>
        <input id="email" name="email" class="modalInput" type="text" placeholder="Email"/><br/><br/>
        <input type="hidden" id="action_type" name="action"/><br/>
        <input id="niceButton" type="submit" value="submit"/></br>
    </form>
    </table>
    </form>
    </div>
</div>


<script defer src="utils/js/modal.js"></script>
<script>
      function deleteU() {

        let result = confirm("Want to delete?");
        if (result) {
            $.ajax({
                type : "POST",
                url  : "utils/php/logic/user_delete.php",
                success: function(res){  
                    location.reload();
                }
            }); 
        }
    }

    function callEdit()
    {

        let first_name = "<?php echo $_SESSION['first_name'];?>";
        let last_name = "<?php echo $_SESSION['last_name'];?>";
        let email = "<?php echo $_SESSION['email'];?>";
        let modal =  document.querySelector("#myModal");

        console.log('hi: ' + first_name);

        editProfileModal(modal, first_name, last_name, email)
    }
</script>

  </div>
</div>
<?php
include_once 'utils/php/design/footer.php';
?>