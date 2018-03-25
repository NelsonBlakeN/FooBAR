import serial   # Import serial library
import time
from api.PythonAPI import PythonAPI
from TrafficCounterFSM import TrafficCounterFSM

DEV_PORT = '/dev/ttyACM0'   # Fill in by testing
FRONT_PIN_L = 0
BACK_PIN_L = 0
FRONT_PIN_R = 0
BACK_PIN_R = 0

arduinoSerialData = serial.Serial(DEV_PORT, 9600)
left_fsm = TrafficCounterFSM(FRONT_PIN_L, BACK_PIN_L)
right_fsm = TrafficCounterFSM(FRONT_PIN_R, BACK_PIN_R)
api = PythonAPI()

print("Running FooBAR...")

iter = 0
while True:
    if arduinoSerialData.inWaiting() > 0:
        # 0 0 0 0 x 1 1 0 0 x ....
        # Recieved pin number of updated sensor
        data = arduinoSerialData.readline()
        if iter == 0:
            frontLeftData = data
        elif iter == 1:
            backLeftData = data
        elif iter == 2:
            frontRightData = data
        elif iter == 3:
            backRightData = data
        elif iter == 4:
            # Deliminator is reached
            # Update FSMs
            passed_left = left_fsm.updateFSM(frontLeftData, backLeftData)
            passed_right = right_fsm.updateFSM(frontRightData, backRightData)
        if passed_left:
            api.person_passed()
        if passed_right:
            api.person_passed()

