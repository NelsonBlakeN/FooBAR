<?php

// Active assert and make it quiet
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

include('CommonMethods.php');
$debug = true;
$COMMON = new Common($debug);   // common methods

// Assertion handler
function my_assert_handler($file, $line, $code, $desc = null)
{
  echo "Assertion failed at $file:$line: $code";
  if ($desc) {
    echo ": $desc";
  }
  echo "\n"
}

// Set up the callback
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

// Test connection with database
$sql = "SELECT VERSION()"
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
assert(!empty($rs), "Connection with database failed.")

// Test recieving data
// Insert fake data
$sql = "INSERT INTO `blake.nelson`.`TestTable` (`id`, `time`) VALUES ('100', CURRENT_TIMESTAMP)"
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

// Check if it's there
$sql = "SELECT * FROM TestTable WHERE id=100"
assert(!empty($rs), "No results were found.")

// Remove fake data from table
$sql = "DELETE FROM `blake.nelson`.`TestTable` WHERE `TestTable`.`id` = 100"
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

?>
