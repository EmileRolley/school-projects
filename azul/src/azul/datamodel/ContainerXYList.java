package azul.datamodel;

public abstract class ContainerXYList extends ContainerXList {

    public ContainerXYList() {
		this( 0, 0 );
	}
	
	public ContainerXYList(int linesLength, int nbLines) {
		super( linesLength * nbLines );
		initializePositions( linesLength );
	}

	protected void initializePositions(int linesLength) {
		int currentXPos;
		TileContainerXY containerXY;

		for (TileContainerX containerX : containerList) {
			containerXY = (TileContainerXY) containerX;
			currentXPos = containerXY.getXPos(); 	
			containerXY.setYPos( currentXPos / linesLength );
			containerXY.setXPos( currentXPos % linesLength );
		}
	}

	@Override
	protected void addEmptyContainers(int nbContainers) {
		while ( nbContainers-- > 0 )
			containerList.add( new TileContainerXY(tail++, 0, this, Color.ALL) );
	}

	@Override
	public String toString() {
		TileContainerXY container;
		String res = "[\n";
		boolean first = true;
		int i = -1;

		for (TileContainerX containerX : containerList) {
			container = (TileContainerXY) containerX;
			i = container.getXPos();
			if ( first ) {
				res += "[";
				first = false;
			} 
			else if ( i == 0 )
				res += "]\n[";
			res += container.toString() + ",";
		}

		return( res +"]\n]" );
	}

    public boolean lineContains(int line, Color color) {
		TileContainerXY containerXY;

		for (TileContainerX containerX : containerList) {
			containerXY = (TileContainerXY)containerX;
			if ( containerXY.getYPos() == line
				&& containerXY.contains(color) )
				return( true );
		}	
        return( false );
	}

	@Override
	public TileContainerXY getTileContainerXYAt(int x, int y) {
		TileContainerXY containerXY;
		
		for (TileContainerX containerX : containerList) {
			containerXY = (TileContainerXY)containerX;
			if ( containerXY.getXPos() == x && containerXY.getYPos() == y )
				return( containerXY );
		}
		return( new TileContainerXY() );
	}

	/** ------------------ TUI ------------------ */

	protected String[] getContentToStringTab(int len, boolean full) {
		String[] content = new String[len];

		for (int i = 0; i < len; ++i) {
			content[i] = "";
			for (int j = 0; j < len; ++j) {
				if ( full || j <= i ) {
					content[i] += getTileContainerXYAt(i, j).toString(this);
					content[i] += j != len-1 ? " " : "";
				}
			}
			content[i] = "|" + Print.completeWithCharTo( content[i], ' ', 34 );
			content[i] += "|";
		}
		return( content );
	}
}