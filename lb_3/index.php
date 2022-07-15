<?php include("connect.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3</title>
    <script>
        var ajax = new XMLHttpRequest();

function first() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseText);
                document.getElementById("result").innerHTML = ajax.response;
            }
        }
    }
    var name = document.getElementById("name").value;
    ajax.open("get", "form1.php?name=" + name);
    ajax.send();
}

function second() {
    var department = document.getElementById("department").value;
   
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax);
                let rows = ajax.responseXML.firstChild.children;
                let result = "<p>Перечень медсёстр отделения <b>" + department + ":</b></row>";
                let resTable = "<table border='1'>";
                resTable = resTable + "<tr><th>NurseName</th></tr>";
                let bodyTable = "";
                for(var i = 0; i < rows.length; i++){
                    bodyTable = "<tr><td>" + rows[i].children[0].firstChild.nodeValue + "</td></tr>";
                }
                result = result + resTable + bodyTable;
                document.getElementById("result").innerHTML = result;
            }    
        }
    }
    ajax.open("get", "form2.php?department=" + department, true);
    ajax.send();
}

function third() {
    ajax.onreadystatechange = function() {
    let rows = JSON.parse(ajax.response);
    console.dir(rows);
     let shift = document.getElementById("shift").value;
     if (ajax.readyState === 4) {
        if (ajax.status === 200) {
            let result = "Перечень палат в <b>" + shift + ":</b> ";
            result = result + "<table border ='1'>";
            result = result + "<tr><th>WardName</th><th>Date</th><th>NurseName</th></tr>";
            for (var i = 0; i < rows.length; i++) {
             result += "<tr><td>" + rows[i].ward_name + "</td>";
             result += "<td>" + rows[i].date + "</td>";
             result += "<td>" + rows[i].name + "</td></tr>";
            }
            document.getElementById("result").innerHTML = result; 
            }
        } 
    };
    var shift = document.getElementById("shift").value;
    ajax.open("get", "form3.php?shift=" + shift);
    ajax.send();
} 
    </script>
</head>

<body>
        <p>Получить перечень палат, в которых дежурит выбранная медсестра:
            <select name="name" id="name">
                <?php
                $sql = 'SELECT DISTINCT `name` FROM nurse';
                foreach ($dbh->query($sql) as $row) {
                    print "<option> $row[name] </option>";
                }
                ?>
            </select>
            <button onclick="first()">Ок</button>
    </p>

        <p>Получить перечень медсёстр, выбранного отделения:
            <select name="department" id="department">
                <?php
                $sql = 'SELECT DISTINCT department FROM nurse';
                foreach ($dbh->query($sql) as $row) {
                    print "<option> $row[department] </option>";
                }
                ?>
            </select>
            <button onclick="second()">Ок</button>
        </p>

        <p>Получить перечень палат в указанную смену:
            <select name="shift" id="shift">
                <?php
                $sql = 'SELECT DISTINCT shift FROM nurse';
                foreach ($dbh->query($sql) as $row) {
                    print "<option> $row[shift] </option>";
                }
                ?>
            </select>
            <button onclick="third()">Ок</button>
        </p>
    <div id="result"></div>    
</body>
</html>