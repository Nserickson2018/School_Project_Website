//  book.h
//  HW04
//
//  Created by Jason Fries on 10/17/14.
//  Copyright (c) 2014 Jason Fries. All rights reserved.
//

#ifndef BOOK_H
#define BOOK_H

#include <iostream>

class Book {

private:
    std::string m_isbn;
    std::string m_title;
    std::string m_author;
    float m_rating;
    int m_year;
    
public:
    Book();
    Book(std::string isbn, std::string title, std::string author, int year, float rating);
    //~Book();
    
    int year() const;
    std::string isbn() const;
    std::string author() const;
    std::string title() const;
    float rating() const;
    
    bool operator==(const Book & b) const;
    friend std::ostream & operator<<(std::ostream & os, const Book & b);
    
};

#endif
