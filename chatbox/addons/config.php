<?php
# CHANGUONDYU 10/2009 #

date_default_timezone_set('Asia/Ho_Chi_Minh');

############ SETTINGS ########
$botname = "<font color='violet'>giapnam</font>"; //Thay doi ten bot + mau sac tuy y ban (dung html)

// Forum Address & Security
$config['check_domain_reffer'] = false; // Kiem tra site gui yeu cau
$config['check_chatbox_key'] = false; // Kiem tra tu khoa chat box

$config['forumlink'] = 'diendan.thietkewebcucdep.com'; // link dien dan, ko them ky tu*. / o cuoi', ko them http:// o*? da^u`, nhieu domain thj ngan cach nhau bang dau pha^y? ,
$config['chatboxkey'] = '11022'; // Tu khoa' cua chatbox (phai chinh trong vbulletin options > ChangUonDyU Ex File Chatbox nu*a~ (Cai nay giup bao ve chatbox ko bj nguoi ngoai` phA')

$config['password_tools'] = '1237890'; // mat khau cho file tools.php
$config['managegroup'] = "5,6"; // Nhom thanh vien duoc su dung cac' lenh quan ly chatbox

// POST
$config['checkflood'] = true; // Kiem tra flood
$config['strip_slash'] = true;
$config['max_message_len'] = 2550; // Gioi han ky tu cua lo*j` chat 
$config['remove_badword'] = true; // Loc tu+` ca^m'

// Message
$config['autorefresh'] = 10; // Thoi gian tu dong cap nhat, tinh bang giay
$config['maxmessage'] = 30; // So luong tin hien tra o khung chat
$config['archive_messageperpage'] = 50; // so luong loi chat tren 1 trang trong muc lu*u tru*~
$config['removelink'] = false; // Xoa link (de tranh' quang cao'), nhom' quan ly van co the post link
$config['linkmask'] = false; // hie^n. link o? dang. a^N?: [link]

$config['new_at_bottom'] = false; // Dat la TRUE ne^u muon hjen ca^u chat  moi nhat o? duoj' cung`

$config['use_me'] = true; // Bat tat su dung lenh /me
$command['me'] = '/me';

// Time Setting
$config['showtime'] = true; // An / Hien thoi gian.
$config['timeformat'] = "h:i A";
$config['dateformat'] = "d-m"; // dinh dang. ngay` thang'


############ PHRASE ###############
$phrase['prune'] = "had just pruned the shoutbox";
$phrase['archive'] = "Message Archive";
$phrase['today'] = "Today";
$phrase['yesterday'] = "Yesterday";
$phrase['linkmask'] = "[Link]";
$phrase['linkremoved'] = "<i>[Link đã xóa]</i>";
$phrase['bannotice'] = "Ban bi. ca^m' chat. Hay lien he voi nguoi quan ly";
$phrase['notice'] = "<b>Tin mới</b>: ";

$phrase['banned'] = "has just banned user whose UserID is";
$phrase['unbanned'] = "has just unbanned user whose UserID is";
$phrase['banned_name'] = "has just banned";
$phrase['unbanned_name'] = "has just unbanned";


$phrase['accessdenied'] = "<b>Access Denied</b>";
$phrase['pruneusernotice'] = "has just pruned all messages by";
$phrase['nomessagefound'] = '<b>No messages of this user found</b>';
$phrase['checkflood'] = '<b>Không Spam nhé ?</b>';
$phrase['reason'] = 'Lý do';

######## Cac lenh - ban co the thay do^j? le^nh de^? neu bj hack thj nguoi hack cung~ ko nghjch. dc nhieu` ####
$command['prune'] = '/prune';
$command['ban'] = '/ban';
$command['notice'] = '/notice';
$command['unban'] = '/unban';

######## Ban co the doi ten file de tranh bi nguoi khac dom ngo' ########
$fcbfile['message'] = 'data/fcb_message.txt';
$fcbfile['notice'] = 'data/fcb_notice.txt';
$fcbfile['smilie'] = 'data/fcb_smilies.txt';
$fcbfile['badword'] = 'data/fcb_badword.txt';

// datastore file
$fcbfile['ds_smilie'] = 'data/ds_smilies.txt';
$fcbfile['ds_banned'] = 'data/ds_banned.txt';
$fcbfile['ds_lastshout'] = 'data/ds_lastshout.txt';
$fcbfile['ds_notice'] = 'data/ds_notice.txt';

############# NOT SETTINGS - DON'T CHANGE ##########################
$config['cbforumlink'] = explode(',' , $config['forumlink']);
$config['cbforumlink'] = $config['cbforumlink'][0];
?>