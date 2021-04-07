CREATE TABLE `db_hits` (
  `id` bigint(20) NOT NULL,
  `ref` int(11) NOT NULL,
  `sec` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Section: prod, cat, brand, page, file',
  `date` varchar(7) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Data Y-m for Statics',
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Last IP',
  `last` datetime DEFAULT NULL COMMENT 'Last Access',
  `obs` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_hits`
--
ALTER TABLE `db_hits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref` (`ref`,`sec`,`date`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_hits`
--
ALTER TABLE `db_hits`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;