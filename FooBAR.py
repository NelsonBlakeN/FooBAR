import serial   # Import serial library
import time
from api.PythonAPI import PythonAPI

DEV_PORT = '/dev/ttyACM0'   # Fill in by testing

arduinoSerialData = serial.Serial(DEV_PORT, 9600)

print("Running FooBAR...")

while True:
    if arduinoSerialData.inWaiting() > 0:
        print(arduinoSerialData.readline())
