<?php
include_once 'utils/php/design/header.php';
include_once 'utils/php/session/session.php';
include_once 'utils/php/session/database.php';
include_once 'alert.php';
?>

<script>
    let tab = document.querySelector("#index");
        tab.setAttribute('class', 'on');
</script>

<div id="content">
    <h2>List of Events</h2>
    
    <p>Wish to join any of our events? Just click <a href="#">Join</a> you can cancel the meet 3 days before it begins.</p>     
    
    <!-- the container to add the TABLE -->
    <body onload="createTable()">
    <div id="content-table"></div>

    <!-- we need this to close the modal -->
    <div id="overlay"></div> 

    <!-- only an admin can view this button and add new events... this code is probably a big security flaw xd -->
    <?php if($_SESSION['rank'] == 1) echo '<button id="niceButton" data-modal-target="#myModal">Add Event</button>';?>

    <!-- the modal --> 
    <div class="modal" id="myModal">
        <div class="modal-header">
        <div class="title">Add/Edit Modal</div>
        <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body">
        <form action="utils/php/logic/event_action.php" method="post">
            <input type="hidden" id="id_event" name="id_event"/>
            <input id="event_name" class="modalInput" type="text" name="event_name" placeholder="Name"/><br/><br/>
            <input id="event_type" class="modalInput" type="text" name="event_type" placeholder="Type"/><br/><br/>
            <input id="event_limit" class="modalInput" type="text" name="limit_cap" placeholder="Limit"/><br/><br/>
            <input type="hidden" id="action_type" name="action"/><br/>
            <input id="niceButton" type="submit" name="newEvent" value="submit"/></br>
        </form>
        </table>
        </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script defer src="utils/js/modal.js"></script>
<script>

    /* 
    ** Main JavaScript
    ** -------------------------------------------------------------------------------------------
    ** This is the main JavaScript for creating the data table, while also allowing admins to
    ** add new enteries, edit existing enteries and also having the option to delete them from the
    ** database. Regular users will be able to join the event, if the limit cap has not reached.
    ** -------------------------------------------------------------------------------------------
    **/

    let arrHead = ['ID', 'Name', 'Type', 'Limit', 'Maker', 'Options'];

    // returns the size of the object
    Object.size = function(obj) {
        let size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
    return size;
    };

    // function that creates the table along with the headers
    function createTable()
    {
        let empTable = document.createElement('table');
            empTable.setAttribute('id', 'emp-table');
            empTable.setAttribute('class', 'rwd-table');

        // create table headers
        let tr = empTable.insertRow(-1);
        for (let h = 0; h < arrHead.length; h++) {
            let th = document.createElement('th');
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        }

        let div = document.getElementById('content-table');
        div.appendChild(empTable);  // add the data table to the container

        // using the GET method we get the data from the MySQL database
        $.ajax({
            url : 'utils/php/logic/service.php',
            type : 'GET',

            success : function(result){ 
                let obj = jQuery.parseJSON(result);
                let empTab = document.getElementById('emp-table');
            
                // obj.forEach(element => console.log(element)); -- For Testing

                // Get the size of an object
                for (let row = 0; row < Object.size(obj); row++)
                {
                    let rowCount = empTab.rows.length;
                    let tr = empTab.insertRow(rowCount);
                        tr = empTab.insertRow(rowCount);
                    
                    // adding the data for each cell
                    for (let c = 0; c < arrHead.length; c++) 
                    {
                        let td = document.createElement('td');
                            td = tr.insertCell(c);
                
                        let rank = "<?php echo $_SESSION['rank']; ?>";

                        if (c == 5) // the 'options' column
                        {
                            if (rank == 1){    // for admins          
                                // add a button in every new row
                                let img1 = document.createElement('img');
                                    img1.src='images/icons/cog.png';
                                    img1.style.cursor = 'pointer';
                                    img1.setAttribute('onclick', 'editRow(this)');
                                
                                let img2 = document.createElement('img');
                                    img2.src='images/icons/trash.png';
                                    img2.style.cursor = 'pointer';
                                    img2.setAttribute('onclick', 'removeRow(this)');

                                td.appendChild(img1);
                                td.appendChild(img2);
                            }
                            else {      // for users
                                // adding a text link in every new row
                                let link = document.createElement('a');
                                    link.innerHTML = (obj[row]['6']) ? "Leave?" : "Join?"; // if the user is attending the event or not
                                    link.style.cursor = "pointer";
                                    link.setAttribute('onclick', 'attendEvent(this)');

                                td.appendChild(link);
                            }
                        }
                        // the rest of the colums have data from the database.
                        else {
                            let p = document.createElement('p');

                            switch(c)
                            {
                                case 0:
                                    p = document.createTextNode(obj[row]['0']); // for displaying the id_event
                                    break;
                                case 1:
                                    p = document.createTextNode(obj[row]['1']); // for displaying the name of the event
                                    break;
                                case 2:
                                    p = document.createTextNode(obj[row]['2']); // for displaying the type of event
                                    break;
                                case 3:
                                    p = document.createTextNode(obj[row]['3'] + ' out of ' + obj[row]['4']); // for disaplying the current number of attendence
                                    break;
                                case 4:
                                    p = document.createTextNode(obj[row]['5']); // for displaying the makers name
                                    break;
                            }
                            td.appendChild(p);
                        }
                    }
                }
            }
        });
    }

    // ADMIN function: that will delete the event from the system
    function removeRow(oButton) {
        let id_event = oButton.parentNode.parentNode.cells[0].textContent;

        let result = confirm("Want to delete?");
        if (result) {
            $.ajax({
                type : "POST",
                url  : "utils/php/logic/event_delete.php",
                data : { id_event : id_event },
                success: function(res){  
                    location.reload();
                }
            }); 
        }
    }

    // ADMIN function: that will open the modal and with admin input it will update the inforamtion
    function editRow(oButton) {
        let id_event = oButton.parentNode.parentNode.cells[0].textContent;
        let event_name = oButton.parentNode.parentNode.cells[1].textContent;
        let event_type = oButton.parentNode.parentNode.cells[2].textContent;
        let event_limit = oButton.parentNode.parentNode.cells[3].textContent;

        let modal =  document.querySelector("#myModal");
        editModal(modal, id_event, event_name, event_type, event_limit); // goes to js/modal.js
    }
    
    // USER function: that will add or remove them on the selected event's attendence
    function attendEvent(oButton)
    {
        let id_user = "<?php echo $_SESSION['id_user']; ?>";
        let id_event = oButton.parentNode.parentNode.cells[0].textContent;
        
       $.ajax({
            type : "POST",
            url  : "utils/php/logic/event_attend.php",
            data : { id_user : id_user, id_event : id_event },
            success: function(res){  
                location.reload();
            }
        }); 
    }
</script>

<?php
include_once 'utils/php/design/footer.php';
?>