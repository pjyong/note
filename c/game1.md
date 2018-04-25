# 3*3的棋盘

玩家1和玩家2对战，谁先使自己的3个标记连接成水平、垂直或对角线，谁就是赢家。

下面是我的实现代码:
```
# include <stdio.h>

int main(void)
{
	int current = 1;
	int winner = 0;
	int choice;

	char board[3][3] = {
		{'1', '2', '3'},
		{'4', '5', '6'},
		{'7', '8', '9'}
	};

	for(int i = 0;i < 9 && winner == 0;i++){
		printf("\n");
		printf("%c | %c | %c\n", board[0][0], board[0][1], board[0][2]);
		printf("%c | %c | %c\n", board[1][0], board[1][1], board[1][2]);
		printf("%c | %c | %c\n", board[2][0], board[2][1], board[2][2]);
		printf("\n");
		char s;
		printf("现在轮到玩家%d下棋了，请输入\n", current);
		if(current == 1){
			s = '*';
		}else{
			s = '#';
		}
		// 读取
		int isValid = 0;
		int r,c;
		do{
			scanf("%d", &choice);
			r = (choice-1)/3;
			c = (choice-1)%3;
			if(board[r][c]=='*' || board[r][c]=='#' || choice > 9 || choice < 1){
				isValid = 1;
				printf("不是合法下棋位置，你在其他地方下子\n");
			}else{
				board[r][c] = s;
				isValid = 0;
			}
		}while(isValid==1);

		// 检查棋盘是否有胜局
		int hasEqu = 0;
		if(board[0][0] == board[1][1]
		   && board[1][1] == board[2][2]){
			hasEqu = 1;
		}else if(board[0][2] == board[1][1]
		   && board[1][1] == board[2][0]){
			hasEqu = 1;
		}else{
			for(int j=0;j<=2;j++){
				if(board[0][j] == board[1][j]
					&& board[1][j] == board[2][j]){
					hasEqu = 1;
				}else if(board[j][0] == board[j][1]
					&& board[j][1] == board[j][2]){
					hasEqu = 1;
				}
			}
		}
		if(hasEqu){
			winner = current;
			printf("玩家%d获得了胜利！！！\n", current);
			printf("请看比赛结果：\n");
			printf("\n");
			printf("%c | %c | %c\n", board[0][0], board[0][1], board[0][2]);
			printf("%c | %c | %c\n", board[1][0], board[1][1], board[1][2]);
			printf("%c | %c | %c\n", board[2][0], board[2][1], board[2][2]);
			printf("\n");
		}

		current = current == 1 ? 2 : 1;
	}
}

```
