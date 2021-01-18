package azul.datamodel;

import java.util.*;
public class Player {
	
	public static Scanner sc;

    private PlayerBoard playerBoard;
	private boolean		first;
	private Board		board;
    private int			id;
    private int			score;

    public Player(int id, Board board) {
        this.board = board;
        this.id = id;
        playerBoard = null;
        score = 0;
        first = false;
        sc = new Scanner(System.in);
        sc.useDelimiter("\n");
    }

    public void setPlayerBoard(PlayerBoard playerBoard) {
        this.playerBoard = playerBoard;
    }
    
    public PlayerBoard getPlayerBoard() {
        return playerBoard;
    }

    public int getId() {
        return id;
    }

    public int getScore() {
        return score;
    }

    public void setFirst(boolean first) {
        this.first = first;
    }

    public boolean getFirst() {
        return first;
    }

    public void cleanPlayerBoard() {
        playerBoard.decorateWall();
        score = playerBoard.calcScore();
        playerBoard.drainFloor();
    }

    public int calcBonusScore() {
        score += playerBoard.calcBonusScore();
        return score;
    }

    public boolean hasWallWithCompletedLine() {
        return playerBoard.hasWallWithCompletedLine();
    }

    public void play() {
        ArrayList<Tile> tiles = selectTiles();
        
        if (!tiles.isEmpty())        
            transferTiles( tiles );
    }

    private ArrayList<Tile> selectTiles() {
        ArrayList<Tile> tiles = null;

        while ( tiles == null ) {
            String request = askPlayer( "src" );
            tiles = getRequestedTiles( request );
        }
        return tiles;
    }

    public ArrayList<Tile> getRequestedTiles(String request) {
        String[] args = request.split(" ");

        try {
            ContainerXList containerList = getRequestedContainer( args );
            Color color = getRequestedColor( args );
            return requestTiles(containerList, color);
        } 
        catch (Exception e) { 
            return null; 
        }
    }

    private ArrayList<Tile> requestTiles(
		ContainerXList containerList, Color color
	) {
		ArrayList<Tile> tiles = null;

        if ( color != null && containerList != null ) {
        	tiles = containerList.get(color);
            if ( !tiles.isEmpty() )
            	executeAdditionnalTransfers(containerList, tiles);
		}
        return tiles;
    }

    private void executeAdditionnalTransfers(
		ContainerXList containerList, ArrayList<Tile> tiles
	) {
        if (containerList instanceof Factory)
            transferRemainingTilesInCenter(containerList);
        else
            transferFirstPlayerTileInFloor(tiles);
    }

    private void transferRemainingTilesInCenter(ContainerXList containerList) {
        board.getCenter().add( containerList.get(Color.ALL) );
    }

    private void transferFirstPlayerTileInFloor(ArrayList<Tile> tiles) {
        if ( !containsFirstPlayerTile(tiles) )
            fetchFirstPlayerTileAndTransfer(tiles);
        else 
            sendFirstPlayerTileToFloor(tiles);
    }

    private boolean containsFirstPlayerTile(ArrayList<Tile> tiles) {

        for (Tile t : tiles) {
            if (t.getColor() == Color.FIRST)
                return true;
        }

        return false;
    }
    
    private void fetchFirstPlayerTileAndTransfer(ArrayList<Tile> tiles) {
        Tile tile = board.getCenter().getFirstPlayerTile();

        if ( tile != null ) {
            tiles.add(tile);
            sendFirstPlayerTileToFloor(tiles);
        }
    }

    private ContainerXList getRequestedContainer(String[] args) 
    throws IndexOutOfBoundsException, IllegalArgumentException {
        if ( args[0].compareTo("c") == 0 )
            return board.getCenter();
        else if ( args[0].compareTo("f") == 0 ) {
            Integer factoryNumber = Integer.valueOf( args[1] );
            return board.getFactory( factoryNumber );
        }
        return null;
    }

    private Color getRequestedColor(String[] args) 
	throws
		IndexOutOfBoundsException,
		NumberFormatException,
		IllegalArgumentException
	{
        int i = args[0].compareTo("c") == 0 ? 1 : 2;
        return Color.get( args[i] );
    }

    private void sendFirstPlayerTileToFloor(ArrayList<Tile> tiles) {
        int index = indexFirstPlayerTile(tiles);

        if ( index != -1 )
            playerBoard.addToFloor( tiles.remove(index) );            
    }

    public int indexFirstPlayerTile(ArrayList<Tile> tiles) {
        for (int i = 0; i < tiles.size(); i++)
            if ( tiles.get(i).getColor() == Color.FIRST )
                return i;
        return -1;
    }

    private void transferTiles(ArrayList<Tile> tiles) { 
        String destination;

        do
            destination = askPlayer( "dest" );
        while ( !tryToTransferTiles(tiles, destination) );
    }

    private boolean tryToTransferTiles(ArrayList<Tile> tiles, String destination) {
        try {            
            int idLine = Integer.parseInt(destination);
            boolean success = playerBoard.transferTiles(idLine, tiles);

            return success;
        }
        catch (Exception e) {
			return false;
		}
    }

    /**
	 * TODO : à améliorer.
     * @param question asked to the player.
     * @return the user's keyboard entry.
     */
    public String askPlayer(String question) {
        System.out.println("please enter a " + question);
        return sc.next();
    }   
}