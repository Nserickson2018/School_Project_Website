#!/usr/bin/python

class Employee:
	#declare class variables
	name = ""
	location = ""
	salary = int()
	status = ""
	
	#initialize all variables of the class
	def __init__(self,name,loc,sal,sta):
		self.name = name
		self.location = loc
		self.salary = sal
		self.status = sta
	#functions to change details of Employee
	def changeName(self,name):
		self.name = name
	
	def changeSalary(self,sal):
		self.salary = sal
		
	def changeLocation(self,loc):
		self.location = loc
	
	def changeStatus(self):
		if self.status == "active":
			self.status = "inactive"
		else:
			self.status = "active"
	#print details of object
	def printDetails(self):
		print "Name:",self.name
		print "Location:",self.location
		print "Salary:",self.salary
		print "Status:",self.status
	
class Manager(Employee):
	employeeList = []
	
	def __init__(self,name,loc,sal,sta,empList):
		#initialize Employee obj for Manager and assign value to employeeList
		Employee.__init__(self, name,loc , sal, sta)
		self.employeeList = empList
		
	def printEmployeeNames(self):
		print "Employees managed by",self.name,"are:"
		for employee in self.employeeList:
			print employee.name
	def printDetails(self):
		#Print parent printDetails() function and extra details relevant for this class
		Employee.printDetails(self)
		self.printEmployeeNames()
	
#example objects	
employee1 = Employee("Rose", "Dublin", 5000, "active")
employee2 = Employee("Slash", "Dublin", 5000, "active")
employee3 = Employee("Peter Pan", "New York", 5000, "active")
manager1 = Manager("Wayne",'Dublin',5000,'active',[employee1,employee2,employee3])

manager1.changeStatus()
manager1.printDetails()
