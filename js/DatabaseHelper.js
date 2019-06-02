var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "yourusername",
    password: "yourpassword"
});

con.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");
});

function addUser(username, userpassword) {
    con.connect(function (err) {
        if (err) throw err;
        con.query(
            "INSERT INTO `Users` (`userName`, `userPassword`) VALUES (`" + username + "`, `" + userpassword + "`)",
            function (err, result) {
                if (err) throw err;
                console.log("Database created");
            });
    });
}

function addGroup(students, subjects, groupName, userID) {
     con.connect(function (err) {
        if (err) throw err;
        con.query(
            
            function (err, result) {
                if (err) throw err;
                console.log("Database created");
            });
    });
}
