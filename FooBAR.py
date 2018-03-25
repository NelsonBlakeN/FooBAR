import serial   # Import serial library
from api.PythonAPI import PythonAPI
from TrafficCounterFSM import TrafficCounterFSM

# Define constants: representing ports on the board that
# are needed for the appropriate objects.
DEV_PORT = '/dev/ttyACM0'   # Serial port used by Arduino on Raspberry Pi
FRONT_PIN_L = 0		        # Pin used by front left sensor
BACK_PIN_L = 0		        # Pin used by back left sensor
FRONT_PIN_R = 0		        # Pin used by front right sensor
BACK_PIN_R = 0		        # Pin used by back right sensor

# Creating necessary objects
arduinoSerialData = serial.Serial(DEV_PORT, 9600)	    # Collect serial data from Ardunio
left_fsm = TrafficCounterFSM(FRONT_PIN_L, BACK_PIN_L)	# Tracks state of left sensor set
right_fsm = TrafficCounterFSM(FRONT_PIN_R, BACK_PIN_R)	# Tracks state of right sensor set
api = PythonAPI()					                    # Python API object

print("Running FooBAR...")

# Tracks which sensor the current data belongs to
iter = 0

# Flush buffer before beginning
arduinoSerialData.flushInput()

# Synchronize input signals
# x = arduinoSerialData.readline()
# while x != "X":
#     print(x)
#     x = arduinoSerialData.readline()

# Read data from Arduino
while True:
    if arduinoSerialData.inWaiting() > 0:
        # Recieved pin number of updated sensor
        data = arduinoSerialData.read()
        data = (data == "1") # TODO: This will result in an "X" becoming 0. Possible
                             # solution: send all data from Arduino in one byte
        print(str(iter), ": Raw data=", str(data), "(", type(data), ")")

	    # Tracks whether a person passed the box on either side
        passed_left = 0
        passed_right = 0

        if iter == 0:
            frontLeftData = data
        elif iter == 1:
            backLeftData = data
        elif iter == 2:
            frontRightData = data
        elif iter == 3:
            backRightData = data
        elif iter == 4:
            # Deliminator is reached, update FSMs
            passed_left = left_fsm.updateFSM(frontLeftData, backLeftData)
            passed_right = right_fsm.updateFSM(frontRightData, backRightData)

        # If a person passed, update the database through the API
        if passed_left or passed_right:
            api.person_passed()

	    # Update iterator
        if iter < 4:
	        iter += 1
        elif iter >= 4:
	        iter = 0
