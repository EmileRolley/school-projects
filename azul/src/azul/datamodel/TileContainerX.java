package azul.datamodel;

public class TileContainerX {
	
    protected int xPos;
	protected Tile tile;
	protected ContainerXList containerList;
	
	public TileContainerX() {
		this( 0, null );
	}

    public TileContainerX(int xPos, ContainerXList container) {
		this( xPos, null, container );
	}

	public TileContainerX(int xPos, Tile tile, ContainerXList container) {
		this.tile = tile;
		this.xPos = xPos;
		this.containerList = container;
	}
	
	/** Returns the contained tile and removes it from the container. */
    public Tile getTile() {
		Tile collectedTile = tile;
		tile = null;
        return( collectedTile );
    }

    public void setTile(Tile tile) {
		this.tile = tile;
    }

    public int getXPos() {
        return( xPos );
	}

	public void setXPos(int xPos) {
		this.xPos = xPos;
	}

    public boolean isEmpty() {
        return( tile == null );
    }

	public boolean contains(Color color)
	{
		return( !isEmpty() && tile.getColor().equals(color) );
	}

	public int getNbHorizontalAdjacentTiles(Direction dir) {
		TileContainerX container;
		int nbLeft = 0;
		int nbRight= 0;

		if ( isEmpty() )
			return( 0 );
		if ( Direction.LEFT.equals(dir) && xPos > 0
			&& !containerList.getTileContainerXAt(xPos-1).isEmpty() ) {
				container = containerList.getTileContainerXAt( xPos - 1 );
				nbLeft = container.getNbHorizontalAdjacentTiles( Direction.LEFT );
		}
		if ( Direction.RIGHT.equals(dir) && xPos > 0
			&& !containerList.getTileContainerXAt(xPos+1).isEmpty() ) {
				container = containerList.getTileContainerXAt( xPos + 1 );
				nbRight = container.getNbHorizontalAdjacentTiles( Direction.RIGHT );
		}
		return( 1 + nbLeft + nbRight );
	}
	
	/** ------------------ TUI ------------------ */

	/** NOTE : l'objet n'est plus necessaire pour l'instant. */
	public String toString(Object o) {
		String res = "......";

		if ( tile != null ) {
			if ( isNeededToAddSpaces(o) )
				res = Print.completeWithCharTo( tile.toString(),
												'.',
												Color.MAX_LENGTH );
			else
				res = tile.toString();
		}
		return( res );
	}

	protected boolean isNeededToAddSpaces(Object o) {
		return( tile.toString().length() < Color.MAX_LENGTH );
	}
}
