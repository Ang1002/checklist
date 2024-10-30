<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="calendar.css">
    <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
    <title>Calendar</title>

    <style>
body {
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
 }
 
 h3,h4,h5 {
    font-weight: 300 !important;
 }
 
 .calendar-wrapper {
    height: auto;
    max-width: 530px;
    margin: 0 auto;
 }
 
 .calendar-header {
    background-color:rgba(0,0,0,0.1) ;
    height: 100%;
    padding: 20px;
    color: #fff;
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    position: relative;
 }
 
 .header-title {
    padding-left: 15%;
 }
 
 .header-background {
    background-image: url("imagenes/Fondo_simple.png");
    height: 200px;
    background-position: center right;
    background-size: cover;
    opacity: 0.8;
 }
 
 .calendar-content {
    background-color: #fff;
    padding: 20px;
    padding-left: 20%;
    padding-right: 20%;
    overflow: hidden;
 }
 
 .event-mark {
    width: 10px;
    height: 10px;
    background-color:#640909;
    border-radius: 100px;
    position: absolute;
    left: 76%;
    top: 70%;
 }
 
 
 .addEventButtons a {
    color: black;
    font-weight: 300;
 }
 
 .emptyForm {
    padding: 20px;
    padding-left: 15%;
    padding-right: 15%;
 }
 
 .emptyForm h4 {
    color: #fff;
    margin-bottom: 2rem;
 }
 
 .sidebar-wrapper {
    color: #fff;
    background-color: #640909!important;
    padding-top: 0;
    padding-bottom: 20px;
    font-family: 'Roboto', sans-serif;
    font-weight: 300;
    padding-left: 0;
    padding-right: 0;
 }
 
 .sidebar-title {
    padding: 50px 6% 50px 12%;
    background-color: #640909;
 }
 
 .sidebar-title h4 {
    margin-top: 0;
 }
 
 .sidebar-events {
    overflow-x: hidden;
    overflow-y: hidden;
    margin-bottom: 70px;
 }
 
 .empty-message {
    font-size: 1.2rem;
    padding: 15px 6% 15px 12%;
 }
 
 .eventCard {
    background-color: #fff;
    color: black;
    padding: 24px 24px 24px 24px;
    border-bottom: 1px solid #968d8d;
    white-space: nowrap;
    position: relative;
    animation: slideInDown 0.5s;
 }
 

 .eventCard-header {
    font-weight: bold;
 }
 
 .eventCard-description {
    color:#860c0c;
 }
 
 .eventCard-mark-wrapper {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 100px;
    background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 25%, rgba(255, 255, 255, 1) 100%);
 }
 
 .eventCard-mark {
    width: 8px;
    height: 8px;
    background-color: #640909;
    border-radius: 100px;
    position: absolute;
    left: 50%;
    top: 45%;
 }
 
 .day-mark {
    width: 10px;
    height: 10px;
    background-color: #640909;
    border-radius: 100px;
    position: absolute;
    left: 47%;
    top: 67%;
 }
 
 .content-wrapper {
    padding-top: 50px;
    padding-bottom: 50px;
    margin-left: 300px;
 }
 
 #table-body .col:hover {
    cursor: pointer;
    /*border: 1px solid grey;*/
    background-color: #E0E0E0;
 }
 
 .empty-day:hover {
    cursor: default !important;
    background-color: #fff !important;
 }
 
 #table-body .row .col {
    padding: 15px;
 }
 
 #table-body .col {
    border: 1px solid transparent;
 }
 
 #table-body {}
 
 #table-body .row {
    margin-bottom: 0;
 }
 
 #table-body .col {
    padding-top: 1.3rem !important;
    padding-bottom: 1.3rem !important;
 }
 
 #calendar-table {
    text-align: center;
 }
 
 .prev-button {
    position: absolute;
    cursor: pointer;
    left: 0%;
    top: 45%;
    color: grey !important;
 }
 
 .prev-button i {
    font-size: 4em;
 }
 
 .next-button {
    position: absolute;
    cursor: pointer;
    right: 0%;
    top: 35%;
    color: grey !important;
 }
 
 .next-button i {
    font-size: 4em;
 }
 


 .mobile-header {
    padding: 0;
    display: none;
    padding-top: 20px;
    padding-bottom: 20px;
    position: fixed;
    z-index: 99;
    width: 100%;
    background-color: #640909 !important;
 }
 
 .mobile-header a i {
    color: #fff;
    font-size: 38px;
 }
 
 .mobile-header h4 {
    color: #fff;
 }
 
 .mobile-header .row {
    margin-bottom: 0;
 }
 
 .mobile-header h4 {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    font-weight: 300;
 }
 
 @media (max-width:992px) {
    .content-wrapper {
       margin-left: 0;
    }
    .mobile-header {
       display: block;
    }
    .calendar-wrapper {
       margin-top: 100px;
    }
    .sidebar-wrapper {
       background-color: #EEEEEE !important;
    }
    .sidebar-title {
       background-color:#850918 !important;
    }
    .empty-message {
       color: black;
    }
 }
 
 @media (max-width:767px) {
    .content-wrapper .container {
       width: auto;
    }
    .calendar-content {
       padding-left: 5%;
       padding-right: 5%;
    }
    body .row {
       margin-bottom: 0;
    }
 }
 
 @media (max-width:450px) {
    .content-wrapper {
       padding-left: 0;
       padding-right: 0;
    }
    .content-wrapper .container {
       padding-left: 0;
       padding-right: 0;
    }
 }

 .btn {
    display: inline-block;
    padding: 0 20px;
    background-color: #640909;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
}

.btn:hover {
    background-color: #860c0c;
}


    </style>
</head>

<body>

    <div class="mobile-header z-depth-1">
        <div class="row">
            <div class="col-2">
                <a href="#" data-activates="sidebar" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
            </div>
            <div class="col">
                <h4>Vista de checklist</h4>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="sidebar-wrapper z-depth-2 side-nav fixed" id="sidebar">
            <div class="sidebar-title">
                <h4>Vista de usuarios</h4>
                <h5 id="eventDayName">Date</h5>
            </div>
            <div class="sidebar-events" id="sidebarEvents">
                <div class="empty-message">Ningun usuario realizo el checklist</div>
            </div>
        </div>

        <div class="content-wrapper grey lighten-3">
            <div class="container">
                <div class="calendar-wrapper z-depth-2">
                    <div class="header-background">
                        <div class="calendar-header">
                            <a class="prev-button" id="prev">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                            <a class="next-button" id="next">
                                <i class="material-icons">keyboard_arrow_right</i>
                            </a>

                            <div class="row header-title">
                                <div class="header-text">
                                    <h3 id="month-name">February</h3>
                                    <h5 id="todayDayName">Today is Friday 7 Feb</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="calendar-content">
                        <div id="calendar-table" class="calendar-cells">
                            <div id="table-header">
                                <div class="row">
                                    <div class="col">Mon</div>
                                    <div class="col">Tue</div>
                                    <div class="col">Wed</div>
                                    <div class="col">Thu</div>
                                    <div class="col">Fri</div>
                                    <div class="col">Sat</div>
                                    <div class="col">Sun</div>
                                </div>
                            </div>

                            <div id="table-body" class=""></div>
                            <br>

                            <div class="button-container">
        <a href="menu.php" class="btn">Volver al Menú</a>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script>
        $(".button-collapse").sideNav();
    </script>
    <script>
        var calendar = document.getElementById("calendar-table");
        var gridTable = document.getElementById("table-body");
        var currentDate = new Date();
        var selectedDate = currentDate;
        var selectedDayBlock = null;
        var globalEventObj = {};

        var sidebar = document.getElementById("sidebar");

        function createCalendar(date, side) {
            var currentDate = date;
            var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

            var monthTitle = document.getElementById("month-name");
            var monthName = currentDate.toLocaleString("en-US", {
                month: "long"
            });
            var yearNum = currentDate.toLocaleString("en-US", {
                year: "numeric"
            });
            monthTitle.innerHTML = `${monthName} ${yearNum}`;

            if (side == "left") {
                gridTable.className = "animated fadeOutRight";
            } else {
                gridTable.className = "animated fadeOutLeft";
            }

            setTimeout(() => {
                gridTable.innerHTML = "";

                var newTr = document.createElement("div");
                newTr.className = "row";
                var currentTr = gridTable.appendChild(newTr);

                for (let i = 1; i < (startDate.getDay() || 7); i++) {
                    let emptyDivCol = document.createElement("div");
                    emptyDivCol.className = "col empty-day";
                    currentTr.appendChild(emptyDivCol);
                }

                var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                lastDay = lastDay.getDate();

                for (let i = 1; i <= lastDay; i++) {
                    if (currentTr.children.length >= 7) {
                        currentTr = gridTable.appendChild(addNewRow());
                    }
                    let currentDay = document.createElement("div");
                    currentDay.className = "col";
                    if (selectedDayBlock == null && i == currentDate.getDate() || selectedDate.toDateString() == new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()) {
                        selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);

                        document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
                            month: "long",
                            day: "numeric",
                            year: "numeric"
                        });

                        selectedDayBlock = currentDay;
                        setTimeout(() => {
                            currentDay.classList.add("blue");
                            currentDay.classList.add("lighten-3");
                        }, 900);
                    }
                    currentDay.innerHTML = i;

                    //show marks
                    if (globalEventObj[new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()]) {
                        let eventMark = document.createElement("div");
                        eventMark.className = "day-mark";
                        currentDay.appendChild(eventMark);
                    }

                    currentTr.appendChild(currentDay);
                }

                for (let i = currentTr.getElementsByTagName("div").length; i < 7; i++) {
                    let emptyDivCol = document.createElement("div");
                    emptyDivCol.className = "col empty-day";
                    currentTr.appendChild(emptyDivCol);
                }

                if (side == "left") {
                    gridTable.className = "animated fadeInLeft";
                } else {
                    gridTable.className = "animated fadeInRight";
                }

                function addNewRow() {
                    let node = document.createElement("div");
                    node.className = "row";
                    return node;
                }

            }, !side ? 0 : 270);
        }

        createCalendar(currentDate);

        var todayDayName = document.getElementById("todayDayName");
        todayDayName.innerHTML = "Today is " + currentDate.toLocaleString("en-US", {
            weekday: "long",
            day: "numeric",
            month: "short"
        });

        var prevButton = document.getElementById("prev");
        var nextButton = document.getElementById("next");

        prevButton.onclick = function changeMonthPrev() {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1);
            createCalendar(currentDate, "left");
        }
        nextButton.onclick = function changeMonthNext() {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1);
            createCalendar(currentDate, "right");
        }

        function addEvent(title, desc) {
            if (!globalEventObj[selectedDate.toDateString()]) {
                globalEventObj[selectedDate.toDateString()] = {};
            }
            globalEventObj[selectedDate.toDateString()][title] = desc;
        }

        function showEvents() {
            let sidebarEvents = document.getElementById("sidebarEvents");
            let objWithDate = globalEventObj[selectedDate.toDateString()];

            sidebarEvents.innerHTML = "";

            if (objWithDate) {
                let eventsCount = 0;
                for (key in objWithDate) {
                    let eventContainer = document.createElement("div");
                    eventContainer.className = "eventCard";

                    let eventHeader = document.createElement("div");
                    eventHeader.className = "eventCard-header";

                    let eventDescription = document.createElement("div");
                    eventDescription.className = "eventCard-description";

                    eventHeader.appendChild(document.createTextNode(key));
                    eventDescription.appendChild(document.createTextNode(objWithDate[key]));

                    eventContainer.appendChild(eventHeader);
                    eventContainer.appendChild(eventDescription);

                    sidebarEvents.appendChild(eventContainer);

                    eventsCount++;
                }
            } else {
                let emptyMessage = document.createElement("div");
                emptyMessage.className = "empty-message";
                emptyMessage.appendChild(document.createTextNode("Ningun usuario realizo el checklist"));

                sidebarEvents.appendChild(emptyMessage);
            }
        }

        gridTable.onclick = function (e) {
            if (!e.target.classList.contains("col") || e.target.classList.contains("empty-day")) {
                return;
            }

            if (selectedDayBlock) {
                if (selectedDayBlock.classList.contains("blue") && selectedDayBlock.classList.contains("lighten-3")) {
                    selectedDayBlock.classList.remove("blue");
                    selectedDayBlock.classList.remove("lighten-3");
                }
            }
            selectedDayBlock = e.target;
            selectedDayBlock.classList.add("blue");
            selectedDayBlock.classList.add("lighten-3");

            selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), parseInt(e.target.innerHTML));

            var selectedDateString = selectedDate.toISOString().split('T')[0]; // Format date as 'YYYY-MM-DD'
            fetchUserForDate(selectedDateString);

            document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("es-ES", {
                month: "long",
                day: "numeric",
                year: "numeric"
            });
        }

        function fetchUserForDate(date) {
            $.ajax({
                url: '', // URL vacía, ya que estamos en la misma página
                type: 'POST',
                data: { date: date },
                success: function(response) {
                    var data = JSON.parse(response);
                    var sidebarEvents = document.getElementById("sidebarEvents");
                    sidebarEvents.innerHTML = "";

                    var userContainer = document.createElement("div");
                    userContainer.className = "userCard";
                    var userHeader = document.createElement("div");
                    userHeader.className = "userCard-header";
                    userHeader.appendChild(document.createTextNode("Usuario"));

                    var userDescription = document.createElement("div");
                    userDescription.className = "userCard-description";
                    userDescription.appendChild(document.createTextNode(data.user));

                    userContainer.appendChild(userHeader);
                    userContainer.appendChild(userDescription);
                    sidebarEvents.appendChild(userContainer);
                }
            });
        }
    </script>

    <?php
    if (isset($_POST['date'])) {
        $servername = "localhost";
        $username = "zarate";
        $password = "Manchas_2024";
        $dbname = "projectroute";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $date = $_POST['date'];
        $sql = "SELECT user FROM backup WHERE date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $stmt->bind_result($user);

        $response = array();

        if ($stmt->fetch()) {
            $response['user'] = $user;
        } else {
            $response['user'] = "Ningun usuario realizo el checklist";
        }

        $stmt->close();
        $conn->close();

        echo json_encode($response);
        exit;
    }
    ?>
</body>
</html>
