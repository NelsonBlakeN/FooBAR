import serial   # Import serial library

DEV_PORT = ''   # Fill in by testing

arduinoSerialData = serial.Serial(DEV_PORT, 9600)

print("Running FooBAR...")

while True:
    if arduinoSerialData.inWaiting() > 0:
        print(arduinoSerialData.readline())
