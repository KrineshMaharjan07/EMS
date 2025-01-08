<?php
include ('./components/navbar.php');
include ('./components/connect.php');
include('userclass.php');

function isLoggedIn()
{
    // Check if the 'username' session variable exists
    return isset($_SESSION['username']);
}

// If the user is not logged in, redirect them to the login page
if (!isLoggedIn()) {
    echo "<script>
    // Redirect to index.php after the page has loaded
    window.location.href = 'index.php';
</script>";
    exit;
}

// Instantiate the Notice class
$notice = new Notice($conn);

// If delete action is triggered, call manageNotice method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $notice->manageNotice($_POST['delete_id']);
}

// Get the notices
$result = $notice->viewNotice();

?>

<style>
    .btn-open-popup {
        padding: 12px 24px;
        font-size: 18px;
        background-color: green;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .main-content {
        position: relative;
        background-color: #eee;
        min-height: 100vh;
        top: 0;
        left: 80px;
        transition: all 0.5s ease;
        width: calc(100% - 80px);
        padding: 1rem;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th,
    td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .btn-delete {
        padding: 8px 16px;
        font-size: 14px;
        background-color: red;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
</style>

<div class="main-content">
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<table border='1'>";
        echo "<tr><th>Issue Date</th><th>Details</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Issuedate"] . "</td>";
            echo "<td>" . $row["Details"] . "</td>";
            echo "<td>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . $row["NID"] . "'>
                        <button type='submit' class='btn-delete'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    ?>
</div>
