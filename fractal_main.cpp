//  main.cpp
//  Homework 02
//  Author: 

#include <iostream>
#include <math.h>
#include <stdlib.h>
#include <cstdlib>
#include "complex.h"
#include "lodepng.h"
#include "rgb.h"


// struct for storing command line argument values
struct Arguments {
    int width;
    int height;
    int color_depth;
    int max_itr;
    const char * filename;
    double zoom;
    double origin[2];
    Complex c;
};

// Function prototypes
//int julia_recursive( Complex & z, const Complex & c, int itr, int max_itr, const double radius2=4 );
int julia( Complex & z, const Complex & c, const int max_itr=256, const double radius2=4 );
unsigned int parse_args(int argc, const char * argv[], Arguments & args);
void print_usage();

int main(int argc, const char * argv[]) {
    
    // parse command line arguments
    Arguments args;
    if ( !parse_args( argc, argv, args ) ) {
        print_usage();
        return 0;
    }
    
    // print out size of image, and other arguments
    // This is not in the requirements, but it may make debugging easier if you don't want to user a debugger
    //std::cout << "Width: " << args.width << std::endl;
    //std::cout<<"Height: "<<args.height << std::endl;
    //std::cout<<"Color Depth: "<<args.color_depth<<std::endl;
    //std::cout<<"Max Iterations: "<<args.max_itr<<std::endl;
    //std::cout<<"Filename: "<<args.filename<<std::endl;
    //std::cout<<"Zoom: "<<args.zoom<<std::endl;
    
    return EXIT_SUCCESS;
      
    // TODO: allocate our dynamic array of pixels (width x height x 4)
    // use the variable name "img"
    unsigned char * img=new unsigned char[args.width*args.height*4];
    
    // TODO: Loop through all pixels in the image
    for ( int w=0;w<args.width ; w++  ) {
        for ( int h=0;h<args.height ;h++ ) {
            
            // create a complex number for this specific pixel
            // by transforming coordinates to range [-1,1]
            
	    //TODO: Calculate Real Value a
	    double a=1.5*(w-args.width*0.5)/(0.5*args.zoom*args.width);
            //TODO: Calculate complex value  b
	    double b=(h-args.height*0.5)/(0.5*args.zoom*args.height);
	    
            Complex z(a,b);
            
	    //TODO: Complete either the iterative version or recursive version
            // Calculate the escape time
            int esc_t = julia( z, args.c, args.max_itr );
            
            // recursive version
            //int esc_t = julia_recursive(z, args.c, 0, args.max_itr);
            
            // 1D array offset
            int offset = args.color_depth * (h * args.width + w);
            
            rgb color = color_map(esc_t, 0, args.max_itr);
            
            img[ offset + 0 ] = color.r * (esc_t % 256);
            img[ offset + 1 ] = color.g * (esc_t % 256);
            img[ offset + 2 ] = color.b * (esc_t % 256);
            img[ offset + 3 ] = 255;            
        }
    }
    
    // write out PNG file
    std::cout << "Writing fractal to " << args.filename << std::endl;
    unsigned int error = lodepng::encode(args.filename, img, args.width, args.height);
    
    if (error) {
        std::cout << "ERROR: Failed to save png to " << args.filename << std::endl;
    }
    
    delete [] img;

    return 0;
}

// parse command line arguments and return a stuct of parameter values
unsigned int parse_args(int argc, const char * argv[], Arguments & args) {
    
    // defaults
    args.zoom = 1.0;
    args.origin[0] = args.origin[1] = 0;
    args.max_itr = 256;
    args.color_depth = 4;                           // bytes per pixel
    args.c = Complex(-0.7,0.27015);
    
    //TODO: parse command line arguments
    switch ( argc ) {
        case 7:
            //args.origin=std::atoi(argv[6]);
        case 6:
            args.zoom=std::atoi(argv[5]);
	    
        case 4:
	    args.filename=(argv[3]);
            //args.max_itr=std::atoi(argv[3]);
	    //args.color_depth=std::atoi(argv[3]);
	    args.height=std::atoi(argv[2]);
	    args.width=std::atoi(argv[1]);
            break;
        default:
            return 0;   // command line parsing failure
    }
    
    return 1; // command line parsing success
}

//TODO: complete the recursive version or the iterative version
// Feel free to change the parameters if you have an alternative idea

// recursive version
//int julia_recursive( Complex & z, const Complex & c, int itr, int max_itr, const double radius2 ) {
    
    
    //return julia_recursive( , , , );
//}


// iterative version
int julia( Complex & z, const Complex & c, const int max_itr, const double radius2 ) {
  int itr=0;
  while(z.magnitude2() < 4 && itr < max_itr){
    itr++;
    z=z*z+c;
  }
  return itr;
}

// show command line options
void print_usage()
{
    std::cerr << "Usage: " << "fractal <width> <height> <filename> <a> <b>";
    std::cerr << std::endl;
}
