package azul.datamodel;

public enum Direction {

	BOTH	( "both" ),
	UP		( "up" ),
	RIGHT	( "right" ),
	DOWN	( "down" ),
	LEFT	( "left" );

	private String name;

	Direction(String name) {
		this.name = name;
	}

	@Override
	public String toString() {
		return( name );
	}

	public boolean equals(Direction dir) {
		return( dir.toString().compareTo("both") == 0
				|| dir.toString().compareTo(name) == 0 );
	}
}