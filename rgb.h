//
//  rgb.h
//  Homework 2
//  Author:

#ifndef RGB_H
#define RGB_H

#include <iostream>
#include <math.h>

//RGB = Red, Green, and Blue
struct rgb {
    
    double r;
    double g;
    double b;
    
    rgb() : r(0), g(0), b(0) {}
    rgb(double r, double g, double b) : r(r), g(g), b(b) {}

};

// For inspiration see http://paulbourke.net/texture_colour/colourspace/
// You can map the values however you want as long as it produces a reasonable image.
// That is don't map everything to the same RGB color.

// The easiest method is a lineary gray scale.
// That is map [vmin,vmax] -> [0,1] linearly, and set all color components to that value with respect to v

// Note, that beyond getting this to work you will not be graded on this part
// I will provide a reference solution to this part before the homework is due just in case anyone is having trouble

// Return a RGB colour value given a a scalar value v in the range [vmin,vmax]
rgb color_map(double v, double vmin, double vmax)
{
    //v=number of itrations
    rgb c(1.0,1.0,1.0); // white
    
    // Modify c based on v, vmin, and vmax
    double m= 1/(vmax-vmin);
    double b=-m*vmin;
    double y=m*v+b;
    
    return( rgb(y,y,y) );
}

#endif
