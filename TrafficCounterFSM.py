from IRSensor import IRSensor

# The traffic counter is intantiated as a finite state
# machine, to track the different states of the sensors
# and determine if a person has passed.
class TrafficCounterFSM:
    def __init__(self):
        self.state = 0                      # Current state of the device
        self.front_sensor = IRSensor()      # Front sensor of device
        self.back_sensor = IRSensor()       # Back sensor of device

    # Update finite state machine
    # @params: frontData(int), raw data recieved from the front sensor
    #          backData(int), raw data recieved from the back sensor
    # @returns: boolean (raw), whether or not someone has passed the device
    def updateFSM(self, frontData=None, backData=None):
        if frontData is None and backData is None:
            # Bad reading
            return

        # Update sensor FSMs
        front_trigger = self.front_sensor.updateFSM(frontData)
        back_trigger = self.back_sensor.updateFSM(backData)

        # Initial (beginning) state
        if self.state == 0:
            if not front_trigger and back_trigger:
                self.state = 2
            elif front_trigger and not back_trigger:
                self.state = 4
            elif front_trigger and back_trigger:
                self.state = 7
        # Front sensor triggered, back sensor not
        # After state 2
        elif self.state == 1:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 2
            elif front_trigger and back_trigger:
                self.state = 3
        # Back sensor triggered first, front sensor not
        elif self.state == 2:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif front_trigger and not back_trigger:
                self.state = 1
            elif front_trigger and back_trigger:
                self.state = 3
        # Both sensors triggered
        # After state 2
        elif self.state == 3:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 2
            elif front_trigger and not back_trigger:
                self.state = 1
        # Front sensor triggered first, back sensor not
        elif self.state == 4:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 5
            elif front_trigger and back_trigger:
                self.state = 6
        # Back sensor triggered, front sensor not
        elif self.state == 5:
            if not front_trigger and not back_trigger:
                self.state = 0
                # Person passed
                print("Person passed")
                return 1
            elif front_trigger and not back_trigger:
                self.state = 4
            elif front_trigger and back_trigger:
                self.state = 6
        # Both sensors triggered
        # After state 4
        elif self.state == 6:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 5
            elif front_trigger and not back_trigger:
                self.state = 4
        # Both sensors triggered first
        elif self.state == 7:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 8
            elif front_trigger and not back_trigger:
                self.state = 9
        # Back sensor triggered, front sensor not
        # After state 7
        elif self.state == 8:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif front_trigger and not back_trigger:
                self.state = 9
            elif front_trigger and back_trigger:
                self.state = 7
        # Front sensor triggered, back sensor not
        # After state 8
        elif self.state == 9:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 8
            elif front_trigger and back_trigger:
                self.state = 7
        # Default, go back to beginning
        else:
            self.state = 0
        return 0
