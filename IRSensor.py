class IRSensor:
    def __init__(self):
        self.state = 0
        self.tigger = False
        pass

    def updateFSM(data=None):
        if data is None:
            return

        if self.state == 0:
            if data:
                self.state = 1
        elif self.state == 1:
            if data:
                self.state = 2
            else:
                self.state = 0
        elif self.state == 2:
            if data:
                self.state = 3
                self.trigger = True
            else:
                self.state = 0
        elif self.state == 3:
            if not data:
                self.state = 4
        elif self.state == 4:
            if not data:
                self.state = 5
            else:
                self.state = 3
        elif self.state == 5:
            if not data:
                self.state = 0
                self.trigger = False
            else:
                self.state = 3
        else:
            self.state = 0

        return self.trigger
