'''''''''''''''''''''''''''
    File:       FooBAR.py
    Project:    CSCE 315 Project 1, Spring 2018
    Author:     Blake Nelson, Robert Preston
    Date:       3/6/2018
    Section:    504
    E-mail:     blake.nelson@tamu.edu, prestonre@tamu.edu

    This file contains the main function for counting the foot
    traffic through an area. By reading on a serial port of the
    host machine, the program will use the data to update two
    finite state machines, representing both sides of the device.
    It will then use the data to detect the passing of pedestrians,
    and automatically log the information in a database.
'''''''''''''''''''''''''''

import serial
from api.PythonAPI import PythonAPI
from TrafficCounterFSM import TrafficCounterFSM

#-----------------------------------------
# Name: main
# PreCondition:  None
# PostCondition: Database entries will exist, with accurate information about foot traffic
#                in a given area
#-----------------------------------------
def main():
    # Define constants
    DEVPORT = '/dev/ttyACM0'    # Serial port used by Arduino on Raspberry Pi
    BIT1 = 1                    # Bits in serial byte, ordered from right to left
    BIT2 = 2
    BIT3 = 3
    BIT4 = 4
    BAUDRATE = 9600

    # Creating necessary objects
    arduinoSerialData = serial.Serial(DEVPORT, BAUDRATE)    # Collect serial data from Ardunio
    leftFsm = TrafficCounterFSM()                           # Tracks state of left sensor set
    rightFsm = TrafficCounterFSM()                          # Tracks state of right sensor set
    api = PythonAPI()                                       # Python API object

    print("Running FooBAR...")

    # Flush buffer before beginning
    arduinoSerialData.flushInput()

    # Read data from Arduino
    while True:
        if arduinoSerialData.inWaiting() > 0:
            # Recieved byte containing sensor data
            data = arduinoSerialData.read()

            if data:
                data = ord(data)
                frontLeftData  = data & BIT1   # Front left sensor  = 1st bit
                backLeftData   = data & BIT2   # Back left sensor   = 2nd bit
                frontRightData = data & BIT3   # Front right sensor = 3rd bit
                backRightData  = data & BIT4   # Back right sensor  = 4th bit

                # Tracks whether a person passed the box on either side
                passedLeft = leftFsm.UpdateFSM(frontLeftData, backLeftData)
                passedRight = rightFsm.UpdateFSM(frontRightData, backRightData)

                # If a person passed, update the database once per side
                if passedLeft:
                    api.PersonPassed()
                if passedRight:
                    api.PersonPassed()
            else:
                print("Data was none")

if __name__ == "__main__":
    main()
