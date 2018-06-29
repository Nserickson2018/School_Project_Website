//
//  loadfile.h
//  Project4
//
//  Created by Jason Fries on 10/22/14.
//  Copyright (c) 2014 University of Iowa. All rights reserved.
//

#ifndef LOADFILE_H
#define LOADFILE_H

#include "list.h"

unsigned int load_book_data(char * filename, List & list);
std::string * split_str(std::string str, int & n, char delimitter='\t');

#endif
