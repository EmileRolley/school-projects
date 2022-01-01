package azul.datamodel;

public class Wall extends ContainerXYList implements LimitedSize {
	
	private int score;

	public Wall(boolean colored) {
		super( 5, 5 );
		score = 0;
		if ( colored )
			initTileContainersDefault();
		else
			initTileContainersUncolored();
	}
	
	/**
	 * TODO : should be optimizable.
	 */
	private void initTileContainersDefault() {
		TileContainerXY containerXY;
		int x, y;

		for (TileContainerX containerX : containerList) {
			containerXY = (TileContainerXY) containerX;
			x = containerXY.getXPos();
			y = containerXY.getYPos();
			if  ( x == y )
				containerXY.setAcceptedColor( Color.BLUE );
			else if ( (x >= 1 && x - y == 1) || (x == 0 && y == 4) )
				containerXY.setAcceptedColor( Color.YELLOW );
			else if ( (x >= 2 && x - y == 2) || (x - y == -3) )
				containerXY.setAcceptedColor( Color.RED );
			else if ( (x >= 3 && x - y == 3) || (x - y == -2) )
				containerXY.setAcceptedColor( Color.PURPLE );
			else
				containerXY.setAcceptedColor( Color.WHITE );
		}
	}

	private void initTileContainersUncolored() {
		TileContainerXY containerXY;

		for (TileContainerX containerX : containerList) {
			containerXY = (TileContainerXY) containerX;
			containerXY.setAcceptedColor( Color.UNCOLORED );
		}
	}

	@Override
	public String toString() {
		return( "Wall -> " + super.toString() );
	}

	@Override
	public int getMaximalSizeX() {
		return( 5 );
	}
	
	@Override
	public int getMaximalSizeY() {
		return( 5 );
	}

	public int getScore() {
		return( score );
	}

	public int getFinalScore() {
		return( score + calcBonusScore() );
	}

	public void add(int numLine, Tile tile) {
		TileContainerXY containerXY;

		for (TileContainerX containerX : containerList) {
			containerXY = (TileContainerXY) containerX;
			if (
				containerXY.getYPos() == numLine
				&& containerXY.isColorAccepted(tile.getColor())
			) {
				assert
					containerXY.isEmpty() : "Non-empty container : " + containerXY;
				containerXY.setTile( tile );
				updateScore( containerXY );
			}
		}
	}

    private int updateScore(TileContainerXY containerXY) {
		score += getNbAdjacentTiles( containerXY );
        return( score );
	}
	
	private int getNbAdjacentTiles(TileContainerXY containerXY) {
		int res = 0;

		res += containerXY.getNbHorizontalAdjacentTiles( Direction.BOTH );
		res += containerXY.getNbVerticalAdjacentTiles( Direction.BOTH );
		
		/** -1 because added tile is counted two times. */
		return( res - 1 );
	}

    public int calcBonusScore() {
		int res = 0;

		res += 2 * getNbCompletedLine();
		res += 7 * getNbCompletedColumn();
		res += 10 * getNbCompletedColor();

		return( res );
	}
	
	private int getNbCompletedLine() {
		int res = 0;

		for (int i = 0; i < getMaximalSizeY(); ++i)
			if ( isACompletedLine(i) )
				++res;

		return( res );
	}

	public boolean isACompletedLine(int lineNumber) {
		for (int i = 0; i < getMaximalSizeX(); ++i)
			if ( getTileContainerXYAt(i, lineNumber).isEmpty() )
				return( false );
		return( true );
	}

	private int getNbCompletedColumn() {
		int res = 0;

		for (int i = 0; i < getMaximalSizeY(); ++i)
			if ( isACompletedColumn(i) )
				++res;

		return( res );
	}

	private boolean isACompletedColumn(int colnumNumber) {
		for (int i = 0; i < getMaximalSizeY(); ++i)
			if ( getTileContainerXYAt(colnumNumber, i).isEmpty() )
				return( false );
		return( true );
	}

	private int getNbCompletedColor() {
		int res = 0;

		for (int i = 0; i < Color.nbColorsAvailable(); ++i)
			if ( isACompletedColor(Color.get(i)) )
				++res;

		return( res );
	}

	private boolean isACompletedColor(Color color) {
		TileContainerXY tContainerXY;

		for (TileContainerX tContainerX : containerList) {
			tContainerXY = (TileContainerXY) tContainerX;
			if ( tContainerXY.isColorAccepted(color)
				 && tContainerXY.isEmpty() )
				return( false );
		}
		return( true );
	}
	
	/** ------------------ TUI ------------------ */

	public String[] getLinesToString() {
		String[] lines = new String[7];
		String[] content = getContentToStringTab( getMaximalSizeX(), true );

		lines[0] = Print.completeWithCharTo( "- Wall ", '-', 36 );
		for (int i = 0; i < content.length; ++i)
			lines[i+1] = content[i];
		lines[6] = Print.getNMinusChar( 36 );

		return( lines );
	}
}