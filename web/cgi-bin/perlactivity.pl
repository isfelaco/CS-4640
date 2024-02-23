#!/usr/bin/perl
# Use the CGI module
use CGI;

# Create a new CGI object
my $q = CGI->new;

# Access the firstname GET parameter
my $first_name = $q->param('firstname');
my $last_name = $q->param('lastname');
my $food = $q->param('food');

print $q->header();

sub printMessage {
    my $msg = "Hello $first_name $last_name!  Did you have $food for lunch?";
    print $msg;
}

printMessage();