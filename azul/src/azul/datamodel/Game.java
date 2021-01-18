package azul.datamodel;

import java.util.*;

public class Game {

    private ArrayList<Player> players;
    private Board board;
    String variant;

	public Game() {}

    public Game(int nbPlayers, String variant) {
        this.variant = variant;

        initBoard( nbPlayers );
        initPlayerList( nbPlayers );
        initPlayerBoardList( nbPlayers );
        setPlayersPlayerBoard();
	}
	
	public String getVariant() {
		return( variant );
	}

    private void initBoard(int nbPlayers) {        
        int nbFactories = Factory.getNumberOfFactories(nbPlayers);
        board = new Board(nbFactories, this);
    }

    private void initPlayerList(int nbPlayers) {
        int first = new Random().nextInt(nbPlayers);
		
		players = new ArrayList<Player>();
        for (int i = 0; i < nbPlayers; i++) {
			Player player = new Player(i, board);

            if (i == first)
                player.setFirst(true);
            players.add( player );
        }
    }

    private void initPlayerBoardList(int nbPlayerBoards) {
        ArrayList<PlayerBoard> playerBoards = board.getPlayerBoards();

        for (int i = 0; i < nbPlayerBoards; i++) {
            PlayerBoard playerBoard = new PlayerBoard( players.get(i), board );
            playerBoards.add( playerBoard );
        }
    }

    private void setPlayersPlayerBoard() {
        ArrayList<PlayerBoard> playerBoards = board.getPlayerBoards();

        for (int i = 0; i < playerBoards.size(); i++)
            players.get(i).setPlayerBoard( playerBoards.get(i) );
    }

    public void play() {
        while ( !isOver() ) {
			boolean preparationCompleted = preparatoryPhase("classique");

            if ( !preparationCompleted )
                break;
            offerPhase();
            decorationPhase();
        }
        endPhase();
    }
    
    /**
     * @param variant
     * @return false if there is not enough tiles to play another round
     */
    private boolean preparatoryPhase(String variant) {
        return board.preparatoryPhase( variant );
    }

    private void offerPhase() {
        players = sortPlayerOrder();

        while ( !board.isEmpty() )
            playRound();        
    }

    private void playRound() {       
        for (Player player : players) {
            player.play();
            if (board.isEmpty())
                return;
        }
    }

    private ArrayList<Player> sortPlayerOrder() {
        ArrayList<Player> list = new ArrayList<Player>();
		int firstPlayerIndex = findFirstPlayerIndex();

        list.add( players.get(firstPlayerIndex) );
        addRemainingPlayersByOrder(list, firstPlayerIndex);

        return list;
    }

    /**
     * @return the index of the first player in the players list. If there is
     * no first player, return -1 (should never happen)
     */
    private int findFirstPlayerIndex() {
        for (int i = 0; i < players.size(); i++)
            if (players.get(i).getFirst())
                return i;

        return -1;
    }

    private void addRemainingPlayersByOrder(ArrayList<Player> list, 
											int firstPlayerIndex)
	{
        for (int i = firstPlayerIndex + 1; i < players.size(); i++) 
            list.add(players.get(i));

        for (int j = 0; j < firstPlayerIndex; j++)
            list.add(players.get(j));
    }

    private void decorationPhase() {
        for (Player player : players)
            player.cleanPlayerBoard();
    }

    private void endPhase() {
		Player winner;

        calcBonusScore();
        winner = getWinner();
        printWinnerMessage(winner);
    }

    private void calcBonusScore() {
        for (Player player : players)
            player.calcBonusScore();
    }

    private Player getWinner() {
        Player winner = players.get(0);

        for (int i = 1; i < players.size(); i++) {
			Player player = players.get(i);

            if (player.getScore() > winner.getScore())
                winner = player;
        }
        return winner;
    }

    private void printWinnerMessage(Player winner) {
        System.out.println("The winner is : Player " + winner.getId());
    }

    private boolean isOver() {
        for (Player player : players)
            if (player.hasWallWithCompletedLine())
                return true;

        return false;
    }

    public void print() {
		board.print();
	}
}