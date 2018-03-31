'''''''''''''''''''''''''''
    File:       TestCases.py
    Project:    CSCE 315 Project 1, Spring 2018
    Author:     Blake Nelson
    Date:       2/24/2018
    Section:    504
    E-mail:     blake.nelson@tamu.edu

    The containing class and its functions serve as the
    tests that validate the completeness and validity of the
    traffic counter API. It tests that database entries are
    entered successfully, database connections are successful,
    general database executions are successful, and that inputs
    are sanitized properly.
'''''''''''''''''''''''''''

import sys
import traceback
import unittest
from datetime import datetime
sys.path.insert(0,'..')
from api.PythonAPI import PythonAPI


class TestPythonAndDatabase(unittest.TestCase):

    #-----------------------------------------
    # Name: setUp
    # PreCondition:  None
    # PostCondition: Any objects or values needed in the test cases are instantiated/set
    #-----------------------------------------
    def setUp(self):
        self.m_api = PythonAPI()    # API Object

    #-----------------------------------------
    # Name: TestPersonPassed
    # PreCondition:  None
    # PostCondition: The API call for adding DB entries will be tested for effectiveness
    #-----------------------------------------
    def TestPersonPassed(self):
        try:
            # Simulate person passing, and obtain before/after results
            preResults = self.m_api.Execute("SELECT * FROM `blake.nelson`.`Passerbys` ORDER BY date DESC")
            self.m_api.PersonPassed()
            postResults = self.m_api.Execute("SELECT * FROM `blake.nelson`.`Passerbys` ORDER BY date DESC")

            # Confirm that the results were different (there was a new row)
            assert preResults is not postResults, "Test failed: result comparison returned {}".format(str(preResults is not postResults))

            # Remove simulated row
            self.m_api.Execute("DELETE FROM `blake.nelson`.`Passerbys` ORDER BY date DESC limit 1")
        except:
            err = traceback.format_exc()
            assert False, "An exception was caught: \n{}".format(err)

    #-----------------------------------------
    # Name: TestConnectionToDb
    # PreCondition:  None
    # PostCondition: The DB connection will be validated
    #-----------------------------------------
    def TestConnectionToDb(self):
        try:
            # Perform inconsequential query to confirm connection with DB
            results = self.m_api.Execute("SELECT VERSION()")
            assert results is not None, "No results were returned."
        except:
            err = traceback.format_exc()
            assert False, "Connection failed: \n{}".format(err)

    #-----------------------------------------
    # Name: TestDatabasePost
    # PreCondition:  None
    # PostCondition: The API call for executing queries will be evaluated
    #-----------------------------------------
    def TestDatabasePost(self):
        try:
            # Insert fake data into fake table and confirm it exists
            self.m_api.Execute("INSERT INTO `blake.nelson`.`TestTable` (`id`, `time`) VALUES ('100', CURRENT_TIMESTAMP)")
            results = self.m_api.Execute("SELECT * FROM `TestTable` WHERE `TestTable`.`id` = 100")
            assert results is not None, "No results were returned."

            # Remove fake data from table
            self.m_api.Execute("DELETE FROM `blake.nelson`.`TestTable` WHERE `TestTable`.`id` = 100")
        except:
            err = traceback.format_exc()
            assert False, "An exception was caught: \n{}".format(err)

    #-----------------------------------------
    # Name: TestPersonPassed
    # PreCondition:  None
    # PostCondition: Catching bad preconditions on the Execute API call will be evaluated
    #-----------------------------------------
    def TestNullQuery(self):
        try:
            # Attempt an empty query execution, and confirm it was caught
            results = self.m_api.Execute("")
            assert results == "Query was null. Exiting", "Null query was not handled as expected. Error: {}".format(results)
        except:
            err = traceback.format_exc()
            assert False, "An exception was caught: \n{}".format(err)

if __name__ == '__main__':
    unittest.main()
