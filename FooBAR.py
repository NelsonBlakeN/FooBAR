import serial
from api.PythonAPI import PythonAPI
from TrafficCounterFSM import TrafficCounterFSM

# Define constants
DEV_PORT = '/dev/ttyACM0'   # Serial port used by Arduino on Raspberry Pi

# Creating necessary objects
arduinoSerialData = serial.Serial(DEV_PORT, 9600)   # Collect serial data from Ardunio
left_fsm = TrafficCounterFSM()	                    # Tracks state of left sensor set
right_fsm = TrafficCounterFSM()	                    # Tracks state of right sensor set
api = PythonAPI()					                # Python API object

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
            front_left_data  = data&1   # Front left sensor  = 1st bit
            back_left_data   = data&2   # Back left sensor   = 2nd bit
            front_right_data = data&4   # Front right sensor = 3rd bit
            back_right_data  = data&8   # Back right sensor  = 4th bit

            # Tracks whether a person passed the box on either side
            passed_left = left_fsm.updateFSM(front_left_data, back_left_data)
            passed_right = right_fsm.updateFSM(front_right_data, back_right_data)

            # If a person passed, update the database once per side
            if passed_left:
                api.person_passed()
            if passed_right:
                api.person_passed()
        else:
            print("Data was none")
