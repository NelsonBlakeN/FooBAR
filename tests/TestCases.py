import sys
import traceback
import unittest
from datetime import datetime
from PythonAPI import PythonAPI


class TestPythonAndDatabase(unittest.TestCase):

    def setUp(self):
        self.api = PythonAPI()

    # Test connection with database
    def test_connection_to_db(self):
        try:
            results = self.api.execute("SELECT VERSION()")
            assert results is not None, "No results were returned."
        except:
            err = traceback.format_exc()
            assert False, "Connection failed: {}".format(err)

    # Test ability to create new data (execute func)
    def test_database_post(self):
        try:
            self.api.execute("INSERT INTO `blake.nelson`.`TestTable` (`id`, `time`) VALUES ('100', CURRENT_TIMESTAMP)")
            results = self.api.execute("SELECT * FROM `TestTable` WHERE `TestTable`.`id` = 100")
            assert results is not None, "No results were returned."
            self.api.execute("DELETE FROM `blake.nelson`.`TestTable` WHERE `TestTable`.`id` = 100")
        except:
            err = traceback.format_exc()
            assert False, "An exception was caught: {}".format(err)

    # Test input sanitization
    def test_null_query(self):
        try:
            results = self.api.execute("")
            assert results == "Query was null. Exiting", "Null query was not handled as expected. Error: {}".format(results)
        except:
            err = traceback.format_exc()
            assert False, "An exception was caught: {}".format(err)

if __name__ == '__main__':
    unittest.main()
