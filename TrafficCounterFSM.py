from IRSensor import IRSensor

class TrafficCounterFSM:
    def __init__(self, front_pin, back_pin):
        self.state = 0
        self.front_sensor = IRSensor()
        self.back_sensor = IRSensor()
        self.pins = [front_pin, back_pin]
        self.front_pin = front_pin
        self.back_pin = back_pin

    def updateFSM(frontData=None, backData=None):
        if frontData is None and backData is None:
            # Bad reading
            return

        # Update sensor FSMs
        front_trigger = front_sensor.updateFSM(frontData)
        back_trigger = back_sensor.updateFSM(backData)

        if self.state == 0:
            if not front_trigger and back_trigger:
                self.state = 2
            elif front_trigger and not back_trigger:
                self.state = 4
            elif front_trigger and back_trigger:
                self.state = 7
        elif self.state == 1:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 2
            elif front_trigger and back_trigger:
                self.state = 3
        elif self.state == 2:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif front_trigger and not back_trigger:
                self.state = 1
            elif front_trigger and back_trigger:
                self.state = 3
        elif self.state == 3:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 2
            elif front_trigger and not back_trigger:
                self.state = 1
        elif self.state == 4:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 5
            elif front_trigger and back_trigger:
                self.state = 6
        elif self.state == 5:
            if not front_trigger and not back_trigger:
                self.state = 0
                return 1
            elif front_trigger and not back_trigger:
                self.state = 4
            elif front_trigger and back_trigger:
                self.state = 6
        elif self.state == 6:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 5
            elif front_trigger and back_trigger:
                self.state = 4
        elif self.state == 7:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 8
            elif front_trigger and back_trigger:
                self.state = 9
        elif self.state == 8:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif front_trigger and not back_trigger:
                self.state = 9
            elif front_trigger and back_trigger:
                self.state = 7
        elif self.state == 9:
            if not front_trigger and not back_trigger:
                self.state = 0
            elif not front_trigger and back_trigger:
                self.state = 8
            elif front_trigger and back_trigger:
                self.state = 7
        else:
            self.state = 0
        return 0
