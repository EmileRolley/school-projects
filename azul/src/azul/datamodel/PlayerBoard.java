package azul.datamodel;

import java.util.*;

public class PlayerBoard {

	private final int MAX_WIDTH = 80;

    private PatternLines 	patternLines;
    private Player			player;
    private Board			board;
    private Floor			floor;
    private Wall			wall;

    public PlayerBoard(Player player, Board board) {
    	// TODO : adapts to variant.
        boolean colored = true;
		
        this.board = board;
        this.player = player;
        floor = new Floor( board.getOffside().getDiscard() );
        patternLines = new PatternLines();
        wall = new Wall( colored );
	}
	
	public void addToFloor(Tile tile) {
		floor.add( tile );
	}

    public boolean transferTiles(int idLine, ArrayList<Tile> tiles) {
        if ( idLine == -1 ) {
            floor.add( tiles );
            return true;
        }
        return putInLine(idLine, tiles);
    }

    private boolean putInLine(int idLine, ArrayList<Tile> tiles) {
		ArrayList<Tile> remainingTiles;
        ArrayList<TileContainerXY> line = patternLines.getLineAt(idLine);

        if ( !isAdditionToLineValid(line, tiles) )
            return false;
        
        remainingTiles = patternLines.add( line, tiles );
        floor.add( remainingTiles );

        return true;
    }

    private boolean isAdditionToLineValid(
		ArrayList<TileContainerXY> line, ArrayList<Tile> tiles
	) {
		if ( line == null )
			return false;

        boolean lineIsEmpty = patternLines.isLineEmpty(line);
		boolean lineContainsSameColor = patternLines.contains(
											line, tiles.get(0).getColor()
										);
        boolean lineIsFull = patternLines.isLineFull(line);
		
		return(
			lineIsEmpty || (lineContainsSameColor && !lineIsFull)
		);
    }

    public int calcScore() {
        int score = 0;

        score += wall.getScore();
        score += floor.calcScore();

        return score;
    }

    public void decorateWall() {
		for (int y = 0; y < patternLines.getMaximalSizeY(); y++)
			decorateWallLine( y );
    }

    private void decorateWallLine(int idLine) {
        ArrayList<TileContainerXY> line = patternLines.getLineAt( idLine );

        if ( patternLines.isLineFull(line) ) {
            addOneTileToWall( line, idLine );
            discardRemainingTiles( line );
        }
    }

    private void addOneTileToWall(ArrayList<TileContainerXY> line, int idLine) {
        Tile tile = line.get(0).getTile();
        wall.add( idLine, tile );
    }
    
    private void discardRemainingTiles(ArrayList<TileContainerXY> line) {
        for (TileContainerXY container : line)
            board.getOffside().getDiscard().push( container.getTile() );
    }

    /**
     * drains the floor into the discard 
     * and updates the first attribute of the player.
     */
    public void drainFloor() {
        player.setFirst( floor.containsFirstPlayerTile() );
        board.getOffside().getDiscard().push( floor.drain() );
    }
    
    public boolean hasWallWithCompletedLine() {
        for (int i = 0; i < wall.getMaximalSizeY(); i++)
            if ( wall.isACompletedLine(i) ) 
                return true;

        return false;
    }

    public int calcBonusScore() {
        return( wall.calcBonusScore() );
    }

	/** ------------------ TUI ------------------ */

	@Override
	public String toString() {
		return(
			Print.stretch("|  " + getFirstLine()) + "|\n"
			+ Print.stretch("|  " + Print.completeWithCharTo("|", ' ', MAX_WIDTH-1) + "|")
			+ "|\n"
			+ getContent()	
			+ Print.stretch("|  " + Print.completeWithCharTo("|", '-', MAX_WIDTH-1) + "|")
			+ "|\n"
		);
	}

	private String getFirstLine() {
		return(
			Print.completeWithCharTo("- Player " + player.getId() + " ", '-', MAX_WIDTH)
		);
	}

	private String getContent() {
		String content = "";

		content += getWallAndPattern();
		content += getFloorAndScore();

		return( content );
	}

	private String getWallAndPattern() {
		String[] wallToStrings = wall.getLinesToString();
		String[] patternToStrings = patternLines.getLinesToString();
		String res = "";

		for (int i = 0; i < wallToStrings.length; ++i)
			res += Print.stretch(
							"|  |  " +
							Print.completeWithCharTo(patternToStrings[i]
													+ "  " + wallToStrings[i],
													' ', MAX_WIDTH - 4) + "|"
						) + "|\n";
		return( res );
	}

	private String getFloorAndScore() {
		String res = "";
		
		res += Print.stretch(
						"|  |  " +
						Print.completeWithCharTo(floor.getFirstLine()
												+ "      "
												+ "- Score ------",
												' ', MAX_WIDTH - 4) + "|"	
					) + "|\n";
		res += Print.stretch(
						"|  |  " +
						Print.completeWithCharTo(floor.getSecondLine()
												+ "      "
												+ getFormattedScore(),
												' ', MAX_WIDTH - 4) + "|"	
					) + "|\n";
		res += Print.stretch(
						"|  |  " +
						Print.completeWithCharTo(floor.getThirdLine()
												+ "      "
												+ "--------------",
												' ', MAX_WIDTH - 4) + "|"	
					) + "|\n";

		return( res );
	}

	private String getFormattedScore() {
		if ( player.getScore() < 10 )
			return( "|     0" + player.getScore() + "     |" );
		return( "|     " + player.getScore() + "     |" );
	}
}