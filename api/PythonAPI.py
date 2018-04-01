'''''''''''''''''''''''''''
    File:       PythonAPI.py
    Project:    CSCE 315 Project 1, Spring 2018
    Author:     Blake Nelson
    Date:       2/24/2018
    Section:    504
    E-mail:     blake.nelson@tamu.edu

    This file contains the API used on the traffic
    counting device, written in python. It contains a function to
    automatically update a database with information about
    a passing pedestrian, which calls another query execution function
    within the same class.
'''''''''''''''''''''''''''

import sys
import MySQLdb

class PythonAPI:
    def __init__(self):
        pass

    #-----------------------------------------
    # Name: PersonPassed
    # PreCondition:  None
    # PostCondition: An entry will be added to the DB
    #-----------------------------------------
    def PersonPassed(self):
        query = "INSERT INTO Passerbys (`time`, `date`) VALUES (CURRENT_TIME(), CURRENT_DATE())"
        self.execute(query)

    #-----------------------------------------
    # Name: Execute
    # PreCondition:  The SQL query string is valid
    # PostCondition: The query will be executed and results will be returned
    #-----------------------------------------
    def Execute(self, query=None):
        results = None
        conn = None

        # Sanitize input (handle unmet precondition)
        if query is None or query is "":
            return "Query was null. Exiting"
        try:
            # Make connection
            conn = MySQLdb.connect(host="database.cs.tamu.edu", user="blake.nelson", passwd="Tamu@2019", db="blake.nelson")
        except:
            return "Connection failed."

        try:
            # Execute query and commit changes (if any were made)
            cursor = conn.cursor()
            cursor.execute(query)
            conn.commit()

            # Obtain results
            results = cursor.fetchone()
        finally:
            # Always close connection (on fail or success)
            conn.close()

        return results
