-- 修正SQL文
ALTER TABLE page ADD INDEX title(title);
ALTER TABLE activity ADD INDEX user_id_page_id(user_id, page_id);