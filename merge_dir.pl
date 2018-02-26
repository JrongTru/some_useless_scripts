#!/usr/bin/perl

use v5.22.1;
use strict;

my $din;
my $dout;
foreach (@ARGV)
{
	$din = $_ if $_ =~ s/din=(.*)/\1/ && !$din;
	$dout = $_ if $_ =~ s/dout=(.*)/\1/ && !$dout;
}

die "input directory missing" unless $din;

while ( $din =~ s/(.*)\/$/\1/ ){}
while ( $dout =~ s/(.*)\/$/\1/ ){}

#`mkdir $dout` unless -d $dout;

print "$din\n$dout\n";

opendir(TRU, $din) or die "error: $!";
my @a = readdir TRU;
my (@dirs, @d);
closedir TRU;
my $i = 1;
print "entering first loop!\n";
foreach (@a)
{
	my $lpdir = "$din/$_";

	next if ($_ =~ m/^\.+$/);

	if ( !(-d $lpdir) )
	{
		say "$lpdir" if $lpdir =~ m/(.*)?\.pl$/ ;
	}
	elsif( -d $lpdir ? ($lpdir !~ m/^(.*)?\/\.+$/): 0)#&& (-d $_) )
	{
		#print "read the no.[$i] $lpdir directory!\n";
		opendir(SUBDIR, $lpdir) or die "error: $!";
		@d = readdir SUBDIR;
		closedir SUBDIR;
		NEXT_ROUND: foreach (@d)
		{
			next NEXT_ROUND if $_ =~ /^(\.)+/;
			my $path = "$lpdir/$_";
			if( -e $path && -d $path )
			{
				#print "$path is a directory.\n";
				push @dirs, $path;
				#print "|--------------------------------------------|\n";
				next NEXT_ROUND;
			}
			#print "\n|--------------------------------------------|\n";
			say $path if $path =~ m/(.*)?\.sample$/;
			#print "$path is a file!\n";
			#$path =~ tr/\//_/;
			#`echo $path $dout/$fname`;
			#print "$path moved\n";
			#print "|--------------------------------------------|\n";
		}
		my $cnt = @dirs;
		#print "[$cnt] directories in array!\n";
		if( $cnt > 0 )
		{
			@d = undef;
			my $tmp = pop @dirs;
			#print "reading sub directory: $tmp\n";
			opendir( SUBDIR, $tmp) or die "error: $!";
			@d = readdir SUBDIR;
			closedir SUBDIR;
			$lpdir = $tmp;
			#print "|--------------------------------------------|\n";
			goto NEXT_ROUND;
		}
	}
}

