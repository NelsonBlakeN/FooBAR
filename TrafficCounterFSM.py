'''''''''''''''''''''''''''
    File:       TrafficCounterFSM.py
    Project:    CSCE 315 Project 1, Spring 2018
    Author:     Blake Nelson, Robert Preston
    Date:       3/24/2018
    Section:    504
    E-mail:     blake.nelson@tamu.edu, prestonre@tamu.edu

    This file implements the traffic counter as a finite state
    machine object. The FSM recieves raw data and passes it to
    its corresponding sensors. It will then interpret trigger
    events from these sensors, which it translates to pedestrians
    passing.
    In this documentation, "high" means the given sensor is
    triggered (something is in front of it); "low" means it is not.
'''''''''''''''''''''''''''

from IRSensor import IRSensor

# Define states as constants
STATE0 = 0
STATE1 = 1
STATE2 = 2
STATE3 = 3
STATE4 = 4
STATE5 = 5
STATE6 = 6
STATE7 = 7
STATE8 = 8
STATE9 = 9

class TrafficCounterFSM:

    #-----------------------------------------
    # Name: __init__
    # PreCondition:  None
    # PostCondition: The proper member variables and objects will be instatiated
    #-----------------------------------------
    def __init__(self):
        self.m_state = STATE0                   # Current state of the device
        self.m_frontSensor = IRSensor()         # Front sensor of device
        self.m_backSensor = IRSensor()          # Back sensor of device

    #-----------------------------------------
    # Name: UpdateFSM
    # PreCondition:  data from the front and back sensors are present
    # PostCondition: the state of the FSM will be updated to reflect the presence
    #                of a pedestrian in front of the device, and a trigger event
    #                is returned.
    #-----------------------------------------
    def UpdateFSM(self, frontData=None, backData=None):
        # Handle unmet precondition (bad reading)
        if frontData is None and backData is None:
            return

        # Update sensor FSMs
        frontTrigger = self.m_frontSensor.UpdateFSM(frontData)
        backTrigger = self.m_backSensor.UpdateFSM(backData)

        # Initial (beginning) state
        # Front sensor: low
        # Back sensor:  low
        if self.m_state == STATE0:
            if not frontTrigger and backTrigger:
                self.m_state = STATE2

            elif frontTrigger and not backTrigger:
                self.m_state = STATE4

            elif frontTrigger and backTrigger:
                self.m_state = STATE7

        # Front sensor: high
        # Back sensor:  low
        # Follows state 2
        elif self.m_state == STATE1:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif not frontTrigger and backTrigger:
                self.m_state = STATE2

            elif frontTrigger and backTrigger:
                self.m_state = STATE3

        # Front sensor: low
        # Back sensor:  high
        # Follows state 0
        elif self.m_state == STATE2:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif frontTrigger and not backTrigger:
                self.m_state = STATE1

            elif frontTrigger and backTrigger:
                self.m_state = STATE3

        # Front sensor: high
        # Back sensor:  high
        # Follow state 2
        elif self.m_state == STATE3:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif not frontTrigger and backTrigger:
                self.m_state = STATE2

            elif frontTrigger and not backTrigger:
                self.m_state = STATE1

        # Front sensor: high
        # Back sensor:  low
        # Follow state 0
        elif self.m_state == STATE4:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif not frontTrigger and backTrigger:
                self.m_state = STATE5

            elif frontTrigger and backTrigger:
                self.m_state = STATE6

        # Front sensor: low
        # Back sensor:  high
        elif self.m_state == STATE5:
            if not frontTrigger and not backTrigger:
                # Person passed
                self.m_state = STATE0
                return 1

            elif frontTrigger and not backTrigger:
                self.m_state = STATE4

            elif frontTrigger and backTrigger:
                self.m_state = STATE6

        # Front sensor: high
        # Back sensor:  high
        # Follows state 4
        elif self.m_state == STATE6:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif not frontTrigger and backTrigger:
                self.m_state = STATE5

            elif frontTrigger and not backTrigger:
                self.m_state = STATE4

        # Front sensor: high
        # Back sensor:  low
        # Follows state 0
        elif self.m_state == STATE7:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif not frontTrigger and backTrigger:
                self.m_state = STATE8

            elif frontTrigger and not backTrigger:
                self.m_state = STATE9

        # Front sensor: low
        # Back sensor:  high
        # After state 7
        elif self.m_state == STATE8:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif frontTrigger and not backTrigger:
                self.m_state = STATE9

            elif frontTrigger and backTrigger:
                self.m_state = STATE7

        # Front sensor: high
        # Back sensor:  low
        # After state 8
        elif self.m_state == STATE9:
            if not frontTrigger and not backTrigger:
                self.m_state = STATE0

            elif not frontTrigger and backTrigger:
                self.m_state = STATE8

            elif frontTrigger and backTrigger:
                self.m_state = STATE7

        # Catch-all, go back to beginning
        else:
            self.m_state = STATE0

        # Nothing significant has happened
        return 0
