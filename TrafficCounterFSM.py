from IRSensor import IRSensor

class TrafficCounterFSM:
    def __init__:
        self.state = 0
        self.front_sensor = IRSensor()
        self.back_sensor = IRSensor()

    def updateFSM():
        front_trigger = front_sensor.updateFSM()
        back_trigger = back_sensor.updateFSM()

        if self.state == 0:
            if not front_trigger and back_trigger:
                self.state = 2
            if front_trigger and not back_trigger:
                self.state = 4
            if front_trigger and back_trigger:
                self.state = 7
        elif self.state == 1:
            if not front_trigger and not back_trigger:
                self.state = 0
            if not front_trigger and back_trigger:
                self.state = 2
            if front_trigger and back_trigger:
                self.state = 3
        elif self.state == 2:
            if not front_trigger and not back_trigger:
                self.state = 0
            if front_trigger and not back_trigger:
                self.state = 1
            if front_trigger and back_trigger:
                self.state = 3
        elif self.state == 3:
            if not front_trigger and not back_trigger:
                self.state = 0
            if not front_trigger and back_trigger:
                self.state = 2
            if front_trigger and not back_trigger:
                self.state = 1
        elif self.state == 4:
            if not front_trigger and not back_trigger:
                self.state = 0
            if not front_trigger and back_trigger:
                self.state = 5
            if front_trigger and back_trigger:
                self.state = 6
        elif self.state == 5:
            if not front_trigger and not back_trigger:
                self.state = 0
                return 1
            if front_trigger and not back_trigger:
                self.state = 4
            if front_trigger and back_trigger:
                self.state = 6
        elif self.state == 6:
            if not front_trigger and not back_trigger:
                self.state = 0
            if not front_trigger and back_trigger:
                self.state = 5
            if front_trigger and back_trigger:
                self.state = 4
        elif self.state == 7:
            if not front_trigger and not back_trigger:
                self.state = 0
            if not front_trigger and back_trigger:
                self.state = 8
            if front_trigger and back_trigger:
                self.state = 9
