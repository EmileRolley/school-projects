package azul.datamodel;

public enum Color {
	
	UNCOLORED	( "uncolored" ),
	ALL			( "all" ),
	/** Printable colors : */
	FIRST		( Color.RESET_COLOR + "first" ),
	BLUE		( "\033[34m", "blue" ),
	YELLOW		( "\033[33m", "yellow" ),
	RED			( "\033[31m", "red" ),
	PURPLE		( "\033[35m", "purple" ),
	WHITE		( "\033[37m", "white" );

	public static final int MAX_NAME_LENGTH = 6;
	/** 6 + 9 = 15 ; "\033[XXm" + "\033[0m" = 9 char. */
	public static final int MAX_LENGTH = 16;
	public static final String RESET_COLOR = "\033[00m";

	public static int nbColorsAvailable() {
		return( 5 );
	}

	public static Color get(int i) {
		switch( i ) {
			case 0	: return( Color.BLUE );
			case 1	: return( Color.YELLOW );
			case 2	: return( Color.RED );
			case 3	: return( Color.PURPLE );
			default	: return( Color.WHITE );
		}
	}

	public static Color get(String s) {
		switch( s ) {
			case "blue"		: return( Color.BLUE );
			case "yellow"	: return( Color.YELLOW );
			case "red"		: return( Color.RED );
			case "purple"	: return( Color.PURPLE );
			case "white"	: return( Color.WHITE );
			case "first"	: return( Color.FIRST );
			default			: return( null );
		}
	}
	
	private String name;
	private String code;

	Color(String name) {
		this( "", name );
	}

	Color(String code, String name) {
		this.name = name;
		this.code = code;
	}

	public String getName() {
		return( name );
	}

	public String toString() {
		return( code + name + RESET_COLOR );
	}

	public boolean equals(Color color) {
		return( color.getName().compareTo("all") == 0
				|| color.getName().compareTo(name) == 0
				|| name.compareTo("all") == 0 );
	}
}