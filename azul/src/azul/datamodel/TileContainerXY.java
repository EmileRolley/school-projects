package azul.datamodel;

public class TileContainerXY extends TileContainerX {

    private int yPos;
	private Color acceptedColor;

	public TileContainerXY() {
		this( 0, 0, null, Color.UNCOLORED );
	}

	public TileContainerXY(
		int xPos, int yPos, ContainerXYList container, Color acceptedColor
	) {
		this( xPos, yPos, null, container, acceptedColor );
    }
	
	public TileContainerXY(
		int xPos, int yPos, Tile tile, ContainerXYList container, Color acceptedColor
	) {
		super( xPos, tile, container );
		this.yPos = yPos;
		this.acceptedColor = acceptedColor;
	}

    public int getYPos() {
        return ( yPos );
	}

	public void setYPos(int yPos) {
		this.yPos = yPos;
	}

	public void setAcceptedColor(Color color) {
		acceptedColor = color;
	}

	public boolean isColorAccepted(Color color) {
		return ( acceptedColor.equals(color) );
	}

	@Override
	public String toString() {
		return(
			"[tile=" + tile + ", color=" + acceptedColor +  "]"
		);
	}

	/** 
	 * Responsibility for adding a tile of the right color
	 * is on the calling method.
	 */
	@Override
	public void setTile(Tile tile) {
		this.tile = tile;
	}
	
	public int getNbHorizontalAdjacentTiles(Direction dir) {
		TileContainerXY container;
		int nbLeft = 0;
		int nbRight= 0;

		if ( isEmpty() )
			return( 0 );
		if ( Direction.LEFT.equals(dir) && xPos > 0
			&& !containerList.getTileContainerXYAt(xPos-1, yPos).isEmpty() ) {
				container = containerList.getTileContainerXYAt( xPos - 1, yPos );
				nbLeft = container.getNbHorizontalAdjacentTiles( Direction.LEFT );
		}
		if ( Direction.RIGHT.equals(dir) && xPos > 0
			&& !containerList.getTileContainerXYAt(xPos+1, yPos).isEmpty() ) {
				container = containerList.getTileContainerXYAt( xPos + 1, yPos ); 
				nbRight = container.getNbHorizontalAdjacentTiles( Direction.RIGHT );
		}
		return( 1 + nbLeft + nbRight );
	}
	
	public int getNbVerticalAdjacentTiles(Direction dir) {
		TileContainerXY container;
		int nbUp = 0;
		int nbDown = 0;

		if ( isEmpty() )
			return( 0 );
		if ( Direction.DOWN.equals(dir) && yPos > 0
			&& !containerList.getTileContainerXYAt(xPos, yPos-1).isEmpty() ) {
				container = containerList.getTileContainerXYAt( xPos, yPos - 1 );
				nbDown = container.getNbHorizontalAdjacentTiles( Direction.LEFT );
		}
		if ( Direction.UP.equals(dir) && yPos > 0
			&& !containerList.getTileContainerXYAt(xPos, yPos+1).isEmpty() ) {
				container = containerList.getTileContainerXYAt( xPos, yPos + 1 );
				nbUp = container.getNbHorizontalAdjacentTiles( Direction.RIGHT );
		}
		return( 1 + nbUp + nbDown );
	}

	/** ------------------ TUI ------------------ */

	@Override
	public String toString(Object o) {
		String res = "";
		
		if ( o instanceof PatternLines )
			res = "......";

		if ( tile != null )	
			res = format( tile.toString(), true ); 
		else if ( o instanceof Wall )
			res = format( acceptedColor.getName(), false );

		return( res );
	}

	private String format(String str, boolean colored) {
		String res = str;
		int widthMax = Color.MAX_LENGTH;

		if ( isNeededToAddSpaces(str, colored) ) {
			if ( !colored )
				widthMax = Color.MAX_NAME_LENGTH;
			res = Print.completeWithCharTo( str, '.', widthMax );
		}
		return( res );
	}

	private boolean isNeededToAddSpaces(String str, boolean colored) {
		int widthMax = Color.MAX_LENGTH;

		if ( !colored )
			widthMax = Color.MAX_NAME_LENGTH;

		return( str.length() < widthMax );
	}
}