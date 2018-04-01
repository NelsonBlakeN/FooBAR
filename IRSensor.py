'''''''''''''''''''''''''''
    File:       IRSensor.py
    Project:    CSCE 315 Project 1, Spring 2018
    Author:     Blake Nelson, Robert Preston
    Date:       2/24/2018
    Section:    504
    E-mail:     blake.nelson@tamu.edu, prestonre@tamu.edu

    This file implements the IR sensor as a finite state
    machine object, as a way to debounce the raw signal recieved
    from the Arduino. The FSM recieves raw data from its parent
    device, and interprets it based on the raw data from previous
    cycles, which are represented as the states. These cycles of
    data are then converted into trigger events, which are returned
    to the parent device.
    In this documentation, "high" means the given sensor has something
    in front of it; "low" means it does not.
'''''''''''''''''''''''''''

class IRSensor:
    def __init__(self):
        self.m_state = 0          # Current state of IR sensor finite state machine
        self.m_trigger = False    # Trigger state of IR sensor

    #-----------------------------------------
    # Name: UpdateFSM
    # PreCondition:  raw sensor data is given
    # PostCondition: the state of the finite state machine will be updated, and
    #                translated into information about any presence in front of
    #                the sensor. A trigger event will also be returned.
    #-----------------------------------------
    def UpdateFSM(self, data=None):
        # Handle unmet precondition (bad reading)
        if data is None:
            return

        # Initial (beginning) state
        # Sensor is low
        # Not "triggered" (trigger is not set)
        if self.m_state == 0:
            if data:
                self.m_state = 1

        # Sensor was high for 1 cycle
        elif self.m_state == 1:
            if data:
                self.m_state = 2
            else:
                self.m_state = 0

        # Sensor was high for 2 cycles
        elif self.m_state == 2:
            if data:
                self.m_state = 3
                self.m_trigger = True
            else:
                self.m_state = 0

        # Sensor was high for (at least) 3 cycles
        # "Triggered" (trigger is set)
        elif self.m_state == 3:
            if not data:
                self.m_state = 4

        # Sensor was low for 1 cycle
        elif self.m_state == 4:
            if not data:
                self.m_state = 5
            else:
                self.m_state = 3

        # Sensor was low for 2 cycles
        elif self.m_state == 5:
            if not data:
                self.m_state = 0
                self.m_trigger = False
            else:
                self.m_state = 3
        else:
            self.m_state = 0

        return self.m_trigger
