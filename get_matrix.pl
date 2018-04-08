#!/usr/bin/perl

use v5.22.1;
use strict;

my $file = shift;

open MYF, $file;

my $str = do{
	local $/ = undef; 
	<MYF>;
};

close MYF;

my @matrix = split "\n", $str;
my $detect_port = 0;
my $cr = 4;
my $res;
my @pri;

foreach ( @matrix )
{
	my $tmp = $_;
	#$tmp =~ s/\s+/\s/g;
	$tmp =~ s/(^\s+|\s+$)//sgx;
	#say "[$tmp]";
	unless (($res = $tmp =~ m/\[(\s+)?(\d+)\.(\d+)\](\s+)?\w+ \d+/s) || $detect_port)
	{
		next ;
	}
	$detect_port = 2 unless $detect_port;
	$tmp =~ s/\[([^\[])+?\]//g;
	$tmp =~ s/(^\s+|\s+$)//sgx;
	$tmp =~ s/\s+/ /mg;
	
	say "\n".$tmp and next if $res;
	--$detect_port and next if !$tmp;
	@pri = split " ", $tmp;
	$str = undef;
	$str = sprintf( "%s\t%s\t", $pri[0], $pri[1] );
	if ($str =~ /^\s+$/)
	{ next; }

	if ( --$cr ) {
		print $str;
	} else {
		say $str;
		$cr = 4;
	}

}
