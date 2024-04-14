<?php
// Database connection parameters
include '../connections.php';

// SQL commands for creating triggers
$sql = "

    CREATE TRIGGER trg_insert_user
    AFTER INSERT ON users
    FOR EACH ROW
    BEGIN
        INSERT INTO users (user_id, username, useremail, password, role) 
        VALUES (NEW.user_id, NEW.username, NEW.useremail, NEW.password, NEW.role);
    END

    CREATE TRIGGER trg_delete_user
    AFTER DELETE ON users
    FOR EACH ROW
    BEGIN
        DELETE FROM users WHERE user_id = OLD.user_id;
    END

    ;
";

// Execute SQL commands
if ($conn->multi_query($sql) === TRUE) {
    echo "Triggers created successfully";
} else {
    echo "Error creating triggers: " . $conn->error;
}

// Close connection
$conn->close();
?>