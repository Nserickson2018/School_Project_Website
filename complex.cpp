//  complex.cpp
//  Homework 02
//  Author: 

#include "complex.h"
#include <math.h>

// Constructors
Complex::Complex() : m_Real(0), m_Imaginary(0) {}

Complex::Complex (double a, double b) : m_Real(a), m_Imaginary(b) {}

// Destructor
Complex::~Complex() {}

// Magnitude Squared of this number
double Complex::magnitude2() const {
    // TODO: Calculate the magnitude squared
    
    return m_Real*m_Real+m_Imaginary*m_Imaginary;
}

// Addition of complex numbers is defined as:
// (a + bi) + (c + di) = (a + c) + (b + d)i
Complex Complex::operator+(const Complex & c) const {
    //TODO: Addition of complex numbers
  return Complex( this->m_Real + c.m_Real, this->m_Imaginary + c.m_Imaginary );
  //(*this).m_Imaginary + c.m_Imaginary;
}

// Subtraction of complex numbers is defined as:
// (a + bi) - (c + di) = (a - c) + (b - d)i
Complex Complex::operator-(const Complex & c) const {
    //TODO: Subtraction of complex Numbers
  return Complex(this->m_Real-c.m_Real, this->m_Imaginary-c.m_Imaginary);
}

// Multiplication of complex numbers is defined as:
// (a + bi)(c + di) = (ac - bd) + (bc + ad)i
Complex Complex::operator*(const Complex & c) const {
    //TODO: Multiplication of Complex numbers
  Complex x;
  x.m_Real=(this->m_Real*c.m_Real)-(this->m_Imaginary*c.m_Imaginary);
  x.m_Imaginary=(this->m_Real*c.m_Imaginary)+(this->m_Imaginary*c.m_Real);
  return x;
}

// Division
Complex Complex::operator/(const Complex & c) const {
    //TODO: Division of Complex numbers
  Complex x;
  x.m_Real=((this->m_Real*c.m_Real)+(this->m_Imaginary*c.m_Imaginary)/(c.m_Real*c.m_Real)+(c.m_Imaginary*c.m_Imaginary));
  x.m_Imaginary=((this->m_Real*c.m_Imaginary)-(this->m_Imaginary*c.m_Real)/(c.m_Real*c.m_Real)+(c.m_Imaginary*c.m_Imaginary));

  return Complex();
}

// friend function. Notice the lack of complex scope. Why?
std::ostream & operator << (std::ostream & out, const Complex & c)
{
    std::cout << "(" << c.m_Real << " + " << c.m_Imaginary << "i)";
    return out;
}
