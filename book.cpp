//
//
//
//

#include <iostream>
#include "book.h"
#include <string>

using namespace std;

Book::Book() : m_isbn(""), m_title(""), m_author(""), m_rating(0), m_year(0) {}

Book::Book(string isbn, string title, string author, int year, float rating)
{
  m_isbn=isbn;
  m_title=title;
  m_author=author;
  m_year=year;
  m_rating=rating;
}

string Book::author() const
{
  return m_author;
}

string Book::isbn() const
{
  return m_isbn;
}

int Book::year() const
{
  return m_year;
}

string Book::title() const
{
  return m_title;
}

float Book::rating() const
{
  return m_rating;
}


bool Book::operator==(const Book& b) const
{
  if(this->m_isbn.compare(b.m_isbn) == 0){
    return true;
  }
  //since all other statements are not equal, we return false
  return false;
}

std::ostream & operator<<(std::ostream & os, const Book & b)
{
  os << b.m_isbn << "  " << b.m_title << "  " << b.m_author<<" "<<b.m_year << "  " << b.m_rating;
  
  return os;
}



