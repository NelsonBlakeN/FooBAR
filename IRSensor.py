# Each IR sensor is represented as a finite state machine,
# as a way to debounce the raw signal that is recieved
# from the Arduino.
class IRSensor:
    def __init__(self):
        self.state = 0          # Current state of IR sensor finite state machine
        self.trigger = False    # Tracks whether or not the IR sensor is considered "triggered"
        pass

    # Updates that finite state machine, based on the raw
    # data input from the main file.
    # @param: data (int), the raw data sent from the Arduino
    # @returns: self.trigger (bool), whether the device is
    #           considered "triggered"
    def updateFSM(self, data=None):
        if data is None:
            # Bad reading
            return

        print("Data: "+str(data)+"("+str(type(data))+")")
        # Initial (beginning) state
        if self.state == 0:
            print("Sensor state: "+str(self.state))
            if data:
                # Sensor was high for 1 cycle
                self.state = 1
        elif self.state == 1:
            print("Sensor state: "+str(self.state))

            if data:
                # Sensor was high for 2 cycles
                self.state = 2
            else:
                # Sensor is no longer high
                self.state = 0
        elif self.state == 2:
            print("Sensor state: "+str(self.state))

            if data:
                # Sensor was high for 3 cycles, "triggered"
                self.state = 3
                self.trigger = True
            else:
                # Sensor is no longer high
                self.state = 0
        elif self.state == 3:
            print("Sensor state: "+str(self.state))

            if not data:
                # Sensor was low for 1 cycle
                self.state = 4
        elif self.state == 4:
            print("Sensor state: "+str(self.state))

            if not data:
                # Sensor was low for 2 cycles
                self.state = 5
            else:
                # Sensor is still "triggered"
                self.state = 3
        elif self.state == 5:
            print("Sensor state: "+str(self.state))

            if not data:
                # Sensor was low for 3 cycles, no longer "triggered"
                self.state = 0
                self.trigger = False
            else:
                # Sensor is still "triggered"
                self.state = 3
        else:
            print("Sensor state: "+str(self.state))

            # Default, go back to beginning
            self.state = 0

        # Return trigger state
        return self.trigger
